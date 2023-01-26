<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $imageUrl = $this->topic->image;
        if (substr($this->topic->image, 0, 5) != 'https') {
            $imageUrl = Storage::url('/assets/images/' . $this->topic->image);
        }

        $statusName = 'Diajukan';

        switch ($this->status) {
            case 2:
                $statusName = 'Diterima';
                break;

            case 3:
                $statusName = 'Ditolak';
                break;

            case 4:
                $statusName = 'Selesai';
                break;

            case 5:
                $statusName = 'Expired';
                break;

            default:
                $statusName = 'Diajukan';
                break;
        }
        return [
            'id' => $this->id,
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'psikolog_id' => $this->psikolog->id,
            'psikolog_name' => $this->psikolog->name,
            'topic_id' => $this->topic->id,
            'topic_name' => $this->topic->title,
            'topic_image' => $imageUrl,
            'date' => Carbon::parse($this->date)->format('d M Y'),
            'time' => $this->time,
            'type' => $this->type,
            'diagnosis' => $this->diagnosis,
            'status' => $this->status,
            'status_name' => $statusName,
            'meet_at' => $this->meet_at,
            'no_telp' => $this->no_telp,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
