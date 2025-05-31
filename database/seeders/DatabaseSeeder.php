<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()->count(100)->create();
        Tag::factory()->count(50)->create();

        Artisan::call('permissions:generate-all');
        $superAdmin = User::factory()->create([
            'name' => 'TuanTQ',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        $roleList = config('role.default');
        foreach ($roleList as $role) {
            Role::create(['name' => $role]);
        }
        $superAdminRole = Role::query()->where('name', 'admin')->first();
        // sync permissions
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

        $superAdmin->assignRole($superAdminRole);

        User::factory()
            ->count(10)
            ->create()
            ->each(function (User $user) {
                Post::factory()
                    ->count(5)
                    ->create([
                        'user_id' => $user->id,
                        'category_id' => Category::active()->inRandomOrder()->first()->id,
                    ])
                    ->each(function (Post $post) {
                        $tagIds = \App\Models\Tag::query()->inRandomOrder()->limit(random_int(1, 5))->pluck('id');
                        $post->tags()->sync($tagIds);
                    });

            });

    }
}
