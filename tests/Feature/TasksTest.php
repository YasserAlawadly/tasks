<?php

namespace Tests\Feature;

use App\Models\Statistic;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TasksTest extends TestCase
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

    public function test_tasks_page()
    {
        $task = Task::create([
            'title' => 'first task',
            'assigned_to_id' => $this->user->id,
            'assigned_by_id' => $this->admin->id,
            'description' => 'first task description',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('tasks' , function ($collection) use ($task) {
            return $collection->contains($task);
        });
    }

    public function test_statistics_page()
    {
        $statistic = Statistic::create([
            'user_id' => $this->user->id,
            'count' => 2,
        ]);

        $response = $this->get('/statistics');

        $response->assertStatus(200);
        $response->assertViewHas('statistics' , function ($collection) use ($statistic) {
            return $collection->contains($statistic);
        });
    }

    public function test_create_task()
    {
        $task = [
            'title' => 'first task',
            'assigned_to' => $this->user->id,
            'assigned_by' => $this->admin->id,
            'description' => 'first task description',
        ];

        $response = $this->post('/create' , $task);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('tasks' , [
            'title' => 'first task',
            'assigned_to_id' => $this->user->id,
            'assigned_by_id' => $this->admin->id,
            'description' => 'first task description',
        ]);
    }



//    public function test_tasks_api_login()
//    {
//        $user = User::factory()->create();
//        $response = $this->actingAs($user)->get('/api/tasks');
//        $response->assertStatus(200);
//    }
}
