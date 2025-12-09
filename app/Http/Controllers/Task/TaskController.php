<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Permission;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $tasks = Task::query()
            ->unless(auth()->user()->hasAnyPermission(Permission::PERMISSION_SUPER_ADMIN, Permission::PERMISSION_TASK_VIEW), function ($query) {
                $query
                    ->where('user_id', auth()->id())
                    ->orWhere('assigned_id', auth()->id());
            })
            ->latest()
            ->get();

        return TaskResource::collection($tasks);
    }

    /**
     * Store new task and return json response.
     */
    public function store(TaskStoreRequest $request): TaskResource
    {
        $task = Task::query()->create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'assigned_id' => $request->assigned_id,
        ]);

        return new TaskResource($task);
    }

    /**
     * Find task and show details.
     */
    public function show(Task $task): TaskResource
    {
        $this->authorize('view', $task);

        return new TaskResource($task);
    }

    /**
     * Find task and update it.
     */
    public function update(TaskUpdateRequest $request, Task $task): TaskResource
    {
        $this->authorize('update', $task);

        $task->update([
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'assigned_id' => $request->assigned_id,
        ]);

        return new TaskResource($task);
    }

    /**
     * Find task and delete it.
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return response()->json(null, 204);
    }
}
