<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskTestJsonResource extends JsonResource
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
            'item' => json_decode($this->json)->item,
            'item2' => json_decode($this->json)->item2->value,
            'item3' => json_decode($this->json)->item3[0],
            'user_id' => $this->user_id,
        ];
    }
}
