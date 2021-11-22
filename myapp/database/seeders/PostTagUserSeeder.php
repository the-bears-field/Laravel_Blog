<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class PostTagUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('123456')
        ];
        $user  = User::factory()->create($params);
        $tags  = Tag::factory()->count(20)->create();
        $posts = Post::factory()
                        ->count(200)
                        ->create()
                        ->each(function($post) use ($user, $tags) {
                            $post->users()->syncWithoutDetaching($user->id);
                            $post->tags()->syncWithoutDetaching(
                                $tags->random(random_int(1, 20))->pluck('id')->toArray()
                            );
                        });
    }
}
