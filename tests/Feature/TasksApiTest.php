<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TasksApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $this->user = User::factory()->create();
        $this->user->assignRole($userRole);


        $this->admin = User::factory()->create();
        $this->admin->assignRole($adminRole);

    }

    public function test_tasks_api_authenticated_user_can_access()
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/tasks');
        $response->assertStatus(200);
    }

    public function test_tasks_api_unauthenticated_user_cannot_access()
    {
        $response = $this->getJson('/api/tasks');
        $response->assertStatus(401);
    }

    public function test_tasks_api_store_successful()
    {
        $this->actingAs($this->user);

        $task = [
            'title' => 'first task',
            'assigned_to' => $this->user->id,
            'assigned_by' => $this->admin->id,
            'description' => 'first task description',
        ];

        $response = $this->postJson('/api/tasks' , $task);
        $response->assertStatus(200);
    }

    public function test_tasks_api_store_return_error()
    {
        $this->actingAs($this->user);

        $task = [
            'title' => '',
            'assigned_to' => $this->user->id,
            'assigned_by' => $this->admin->id,
            'description' => 'first task description',
        ];

        $response = $this->postJson('/api/tasks' , $task);
        $response->assertStatus(422);
    }

    public function test_tasks_api_destroy_successful()
    {
        $this->actingAs($this->user);

        $task = Task::create([
            'title' => 'first task',
            'assigned_to_id' => $this->user->id,
            'assigned_by_id' => $this->admin->id,
            'description' => 'first task description',
        ]);

        $response = $this->deleteJson('/api/tasks/' . $task->id);
        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks' , $task->toArray());
    }


}
