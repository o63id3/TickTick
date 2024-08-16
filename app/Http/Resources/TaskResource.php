<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'completed' => $this->completed,
            'section' => $this->whenLoaded('section', fn() => SectionResource::make($this->section)),
            'items' => $this->whenLoaded('items', fn() => TaskItemResource::collection($this->items)),
            'taskItemsCount' => $this->whenCounted('items'),
            'completedTaskItemsCount' => $this->whenCounted('completedTaskItems'),
            'uncompletedTaskItemsCount' => $this->whenCounted('uncompletedTaskItems'),
        ];
    }
}
