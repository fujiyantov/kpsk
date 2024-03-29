<?php

namespace App\Http\Resources;

use DatePeriod;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        switch ($this->category_id) {
            case '1':
                $category = 'category-1';
                break;

            case '2':
                $category = 'category-2';
                break;

            case '3':
                $category = 'category-3';
                break;

            case '4':
                $category = 'category-4';
                break;

            default:
                $category = 'undifined';
                break;
        }

        $imageUrl = $this->image;
        if (substr($this->image, 0, 5) != 'https') {
            $imageUrl = Storage::url('/assets/images/' . $this->image);
        }

        $user = $this->psikolog;
        $scheduleDate1 = $this->getDayDate($user->day);

        $date2 = null;
        $day2 = null;
        if (isset($user->day_2) && $user->day_2 != NULL) {
            $scheduleDate2 = $this->getDayDate($user->day_2);
            $date2 = Carbon::parse($scheduleDate2['date'])->format('d M Y');
            $day2 = $scheduleDate2['day_name'];
        }


        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $category,
            'image' => $imageUrl,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->toDateString(),
            'day' => $user->day,
            'time' => $user->time,
            'schedule' => Carbon::parse($scheduleDate1['date'])->format('d M Y'),
            'day_name' => $scheduleDate1['day_name'],
            'no_telp' => $user->no_telp,
            'meet_at' => $user->meet_at,
            'schedule2' => $date2,
            'day_name2' => $day2,
        ];
    }

    private function getRequestDay($day)
    {
        return new DatePeriod(
            Carbon::parse("first " . $day . " of this month"),
            CarbonInterval::week(),
            Carbon::parse("first " . $day . " of next month")
        );
    }

    private function getDayDate($day)
    {
        switch ($day) {
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

        return [
            'date' => $scheduleDate,
            'day_name' => $labelOfDay
        ];
    }
}
