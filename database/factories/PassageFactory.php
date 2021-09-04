<?php

namespace Database\Factories;

use App\Models\Passage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PassageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Passage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'toefl_id' => 5,
            'imageable' => 'toefl/images/passages/uN8RBIfuykhOhjZeSpuTXyyXp2ECUThWsLf7tdPP.png',
        ];
    }
}
