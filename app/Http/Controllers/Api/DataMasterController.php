<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataMasterController extends Controller
{
    public function getAllFaculty()
    {
        $collections = Faculty::all();

        return response()->json([
            'data' => $collections
        ], Response::HTTP_OK);
    }

    public function getAllStudyProgram()
    {
        $collections = StudyProgram::all();

        return response()->json([
            'data' => $collections
        ], Response::HTTP_OK);
    }

    public function getStudyProgramByFaculty(Request $request, $facultyId)
    {
        $collections = StudyProgram::where('faculty_id', $facultyId)->get();

        return response()->json([
            'data' => $collections
        ], Response::HTTP_OK);
    }
}
