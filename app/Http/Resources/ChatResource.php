<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'is_sender' => $this->patient_id != NULL ? true : false,
            'schedule_id' => $this->schedule_id,
            'patient_id' => $this->patient_id,
            'psikolog_id' => $this->psikolog_id,
            'messages' => $this->messages,
            'is_read' => $this->is_read,
            'created_at' => Carbon::parse($this->created_at)->addHour('7')->format('H:i'),
        ];
    }
}
