<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class productFactory extends Factory
{
 
    public function definition(): array
    {
        return [
            'product_name' => fake()->name(),
            'product_price' => rand(10,100),
            'sale' => 10,
            'rating' => rand(10,100),
            'product_img'=> 'https://th.bing.com/th/id/OIP.G9jh6_xecCZ9nGPCJOteUAHaGd?rs=1&pid=ImgDetMain'
        ];
    }
}
