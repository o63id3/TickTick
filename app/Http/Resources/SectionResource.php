<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'name' => $this->name,
            'list' => $this->whenLoaded('list', fn() => ListResource::make($this->list)),
            'tasks' => $this->whenLoaded('tasks', fn() => TaskResource::collection($this->tasks)),
            'tasksCount' => $this->whenCounted('tasks'),
            'completedTasksCount' => $this->whenCounted('completedTasks'),
            'uncompletedTasksCount' => $this->whenCounted('uncompletedTasks'),
        ];
    }
}
