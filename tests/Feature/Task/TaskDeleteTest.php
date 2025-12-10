<?php

use App\Jobs\AuditLogStoreQueue;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\deleteJson;

test('login user can delete task', function () {
    // Mock Queue
    Queue::fake();

    $user = User::factory()->create();
    $task = Task::factory()->create(['user_id' => $user->getKey()]);

    $response = actingAs($user)->deleteJson(route('tasks.destroy', $task->getKey()));
    $response->assertNoContent();

    // DB Assertions
    assertDatabaseCount('tasks', 0);

    // Queue Assertions
    Queue::assertPushed(AuditLogStoreQueue::class);
});

test('guest user can not delete task', function () {
    $task = Task::factory()->create();

    $response = deleteJson(route('tasks.destroy', $task->getKey()));
    $response->assertUnauthorized();

    // DB Assertions
    assertDatabaseCount('tasks', 1);
});
