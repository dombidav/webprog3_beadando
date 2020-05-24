<?php

use App\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class, 50)->create();
        factory(\App\Project::class, 30)->create();
        factory(\App\Mail::class, 100)->create();
        factory(\App\Message::class, 100)->create();
        factory(\App\Log::class, 200)->create();

        foreach (\App\Project::all() as $project) {
            for ($i = 0; $i < rand(5, 30); $i++) {
                $project->tasks()->save(factory(\App\Task::class)->make());
            }
            DB::table('user_project')->insert([
                'user_id' => $project->owner()->id,
                'project_id' => $project->id
            ]);
            for ($i = 0; $i < rand(1, 10); $i++) {
                DB::table('user_project')->insert([
                    'user_id' => \App\User::all()->where('id', '<>', $project->owner()->id)->random()->id,
                    'project_id' => $project->id
                ]);
            }
        }

        foreach (\App\Task::all() as $task) {
            DB::table('user_task')->insert([
                'user_id' => Task::owner_of($task)->id,
                'task_id' => $task->id
            ]);
            for ($i = 0; $i < rand(0, 5); $i++) {
                DB::table('user_task')->insert([
                    'user_id' => \App\User::all()->where('id', '<>', Task::owner_of($task))->random()->id,
                    'task_id' => $task->id
                ]);
            }
        }
    }
}
