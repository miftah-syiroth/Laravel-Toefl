<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'toefl_id' => 5,
            'section_id' => 3,
            'passage_id' => 30,
            'question' => $this->faker->sentence(),
            'option_a' => $this->faker->sentence(),
            'option_b' => $this->faker->sentence(),
            'option_c' => $this->faker->sentence(),
            'option_d' => $this->faker->sentence(),
            'key_answer' => rand(1, 4),
        ];
    }
}
