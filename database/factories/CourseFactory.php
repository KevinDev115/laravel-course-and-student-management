<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = $this->faker->dateTimeBetween('next Monday', 'next Monday +7 days');
        $end = $this->faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +2 days');

        return [
            'name' => $this->faker->sentence(2),
            'schedule' => $this->faker->randomElement([
                "Lunes", 
                "Martes", 
                "Miercoles", 
                "Jueves", 
                "Viernes"
            ]),
            'start_date' => $start,
            'end_date' => $end
        ];
    }
}
