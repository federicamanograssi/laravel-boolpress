<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0;$i<4;$i++){
            $new_tag=new Tag();
            $new_tag->name= $faker->sentence(rand(1,3));

            // COSTRUZIONE E VERIFICA SLUUG
            $slug=Str::slug($new_tag->name,'-');
            $existing_slug_tag=Tag::where('slug',$slug)->first();
            $base_slug=$slug;
            $slug_counter=1;

            while($existing_slug_tag){
                $slug= $base_slug.'-'.$slug_counter;
                $slug_counter++;
                $existing_slug_tag=Tag::where('slug',$slug)->first();
            }

            $new_tag->slug=$slug;
            $new_tag->save();
        }
    }
}