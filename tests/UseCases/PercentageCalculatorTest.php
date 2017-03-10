<?php

namespace Tests\UseCases;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\BadHabit;
use App\Models\BadHabitInstance;

use App\UseCases\PercentageCalculator;

class PercentageCalculatorTest extends TestCase {

	use DatabaseTransactions;


    /****************************************************************************************
    SET UP BAD HABIT
    ****************************************************************************************/

    private function setUpBadHabit() {

        factory(BadHabit::class)->create([
        
            'id' => 1,
            'name' => 'Do Not Smoke',
            'deleted_at' => null
        ]);
    }


    /****************************************************************************************
    TESTS
    ****************************************************************************************/

    /** @test */
    public function current_date_is_a_success() {

    	$this->setUpBadHabit();

    	factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-12'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-13'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 3,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 4,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 5,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-16'
        ]);

    	$currentDate = new \DateTime('2017-02-16');

    	$percentageCalculator = new PercentageCalculator;

    	$percentage = $percentageCalculator->calculateBadHabitPercentage($currentDate);

    	$this->assertEquals(75.00, $percentage);
    }

    /** @test */
    public function current_date_is_a_fail() {

    	$this->setUpBadHabit();

    	factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-12'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-13'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 3,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 4,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 5,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-16'
        ]);

    	$currentDate = new \DateTime('2017-02-16');

    	$percentageCalculator = new PercentageCalculator;

    	$percentage = $percentageCalculator->calculateBadHabitPercentage($currentDate);

    	$this->assertEquals(60.00, $percentage);
    }

}