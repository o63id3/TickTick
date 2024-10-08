<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
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
            'description' => $this->when($this->description, $this->description),
            'user' => $this->whenLoaded('user', fn() => UserResource::make($this->user)),
            'tasksCount' => $this->whenCounted('tasks'),
            'completedTasksCount' => $this->whenCounted('completedTasks'),
            'uncompletedTasksCount' => $this->whenCounted('uncompletedTasks'),
        ];
    }
}
