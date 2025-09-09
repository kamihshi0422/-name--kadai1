<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name'=> $this->faker->lastName,
            'gender'=> $this->faker->numberBetween(1,3),
            'email'=> $this->faker->safeEmail,
            'tel'=> $this->faker->phoneNumber,
            'address'=> $this->faker->address,
            'building'=> $this->faker->secondaryAddress,
            'detail'=> $this->faker->realText(50), // 50文字くらいのランダム文章   
            'category_id'=> $this->faker->numberBetween(1, 5), 
        ];
    }
}
