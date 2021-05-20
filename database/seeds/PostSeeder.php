<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0;$i<4;$i++){
            $new_post=new Post();
            $new_post->title= $faker->sentence(rand(2,6));
            $new_post->content= $faker->text(rand(100,200));

            // COSTRUZIONE E VERIFICA SLUUG
            $slug=Str::slug($new_post->title,'-');
            $existing_slug_post=Post::where('slug',$slug)->first();
            $base_slug=$slug;
            $slug_counter=1;

            while($existing_slug_post){
                $slug= $base_slug.'-'.$slug_counter;
                $slug_counter++;
                $existing_slug_post=Post::where('slug',$slug)->first();
            }

            //___________
            $new_post->slug=$slug;
            // $new_post->user_id=rand(1,3);
            $new_post->save();
        };
        
    }
}
