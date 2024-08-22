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
            'completedAt' => $this->completed_at,
            'createdAt' => $this->created_at,
            'section' => $this->whenLoaded('section', fn() => SectionResource::make($this->section)),
            'items' => $this->whenLoaded('items', fn() => TaskItemResource::collection($this->items)),
            'taskItemsCount' => $this->whenCounted('items'),
            'completedTaskItemsCount' => $this->whenCounted('completedItems'),
            'uncompletedTaskItemsCount' => $this->whenCounted('uncompletedItems'),
        ];
    }
}
