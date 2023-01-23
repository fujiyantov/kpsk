<?php

namespace App\Http\Controllers\Api;

use Psy\Util\Str;
use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->guard('api')->user();
        if ($user->role_id != 4) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->guard('api')->user();

        switch ($user->day) {
            case 0:
                $nameOfDay = 'sunday';
                $labelOfDay = 'Minggu';
                break;

            case 1:
                $nameOfDay = 'monday';
                $labelOfDay = 'Senin';
                break;

            case 2:
                $nameOfDay = 'tuesday';
                $labelOfDay = 'Selasa';
                break;

            case 3:
                $nameOfDay = 'wednesday';
                $labelOfDay = 'Rabu';
                break;

            case 4:
                $nameOfDay = 'thursday';
                $labelOfDay = 'Kamis';
                break;

            case 5:
                $nameOfDay = 'friday';
                $labelOfDay = 'Jumat';
                break;

            case 6:
                $nameOfDay = 'saturday';
                $labelOfDay = 'Sabtu';
                break;

            default:
                $nameOfDay = 'monday';
                $labelOfDay = 'Senin';
                break;
        }

        $days = $this->getRequestDay(strtolower($nameOfDay));
        $collections = [];
        foreach ($days as $day) {
            $collections[] =  Carbon::parse($day)->toDateString();
        }

        $scheduleDate = '';
        $now = date('Y-m-d');
        $x = false;
        foreach ($collections as $item) {
            if ($x == false) {
                if ($now == $item) {
                    $scheduleDate = $item;
                    $x = true;
                }

                if ($item > $now) {
                    $scheduleDate = $item;
                    $x = true;
                }
            }
        }

        $resource = [
            'id' => $user->id,
            'name' => $user->name,
            'nim' => $user->nim,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'password' => $user->password,
            'profile' => 'https://e7.pngegg.com/pngimages/84/165/png-clipart-united-states-avatar-organization-information-user-avatar-service-computer-wallpaper.png',
            'full_name' => $user->full_name,
            'no_telp' => $user->no_telp,
            'bop' => $user->bop,
            'bod' => $user->bod,
            'role_id' => $user->role_id,
            'faculty_id' => isset($user->faculty) ? $user->faculty->id : NULL,
            'faculty_name' => isset($user->faculty) ? $user->faculty->title : NULL,
            'study_program_id' => isset($user->studyProgram) ? $user->studyProgram->id : NULL,
            'study_program_name' => isset($user->studyProgram) ? $user->studyProgram->title : NULL,
            'day' => $user->day,
            'time' => $user->time,
            'schedule' => $scheduleDate,
            'day_name' => $labelOfDay,
            'gender' => $user->gender == 0 ? 'Laki-laki' : 'Perempuan',
            
        ];
        return response()->json($resource, Response::HTTP_OK);
    }

    private function getRequestDay($day)
    {
        return new \DatePeriod(
            Carbon::parse("first " . $day . " of this month"),
            CarbonInterval::week(),
            Carbon::parse("first " . $day . " of next month")
        );
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required, email:unique, max:255',
            'password' => 'required, min:3, string',
            'name' => 'required, min:3, string',
            'nim' => 'string',
            'no_telp' => 'required, numeric',
            // 'birthdate' => 'required, string',
            'faculty_id' => 'numeric|min:1',
            'study_program_id' => 'numeric|min:1',
            'gender' => 'string',
        ]);

        $gender = 1;
        if (strtolower($request->gender) == 'laki-laki') {
            $gender = 0;
        }

        $user = new User();
        $user->email = $request->email;
        $user->email_verified_at = Carbon::now()->format('Y-m-d');
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->nim = $request->nim;
        $user->full_name = $request->name;
        $user->no_telp = $request->no_telp;
        $user->bod = $request->bod;
        $user->role_id = 4;
        $user->faculty_id = $request->faculty_id;
        $user->study_program_id = $request->study_program_id;
        $user->gender = $gender;
        $user->save();

        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}
