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
        return [
            'id' => $this->id,
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'psikolog_id' => $this->psikolog->id,
            'psikolog_name' => $this->psikolog->name,
            'topic_id' => $this->topic->id,
            'topic_name' => $this->topic->name,
            'date' => $this->date,
            'time' => $this->time,
            'type' => $this->type,
            'diagnosis' => $this->diagnosis,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->toDateString(),
        ];
    }
}
