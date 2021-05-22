<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0;$i<4;$i++){
            $new_category=new Category();
            $new_category->name= $faker->sentence(rand(1,3));

            // COSTRUZIONE E VERIFICA SLUUG
            $slug=Str::slug($new_category->name,'-');
            $existing_slug_category=Category::where('slug',$slug)->first();
            $base_slug=$slug;
            $slug_counter=1;

            while($existing_slug_category){
                $slug= $base_slug.'-'.$slug_counter;
                $slug_counter++;
                $existing_slug_category=Category::where('slug',$slug)->first();
            };

            //___________
            $new_category->slug=$slug;
            $new_category->save();
        }
    }
}