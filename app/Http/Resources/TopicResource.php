<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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

        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $category,
            'image' => $imageUrl,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->toDateString()
        ];
    }
}
