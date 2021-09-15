<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PostUserSeeder extends Seeder
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
        $user = User::factory()->create($params);

        for($i = 0; $i < 10; $i++){
            $post = Post::factory()->create();
            $user->posts()->syncWithoutDetaching($post->id);
        }
    }
}
