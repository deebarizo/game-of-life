<?php

namespace Tests\UseCases;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\BadHabit;
use App\Models\BadHabitInstance;

use App\UseCases\StreakCalculator;

class StreakCalculatorTest extends TestCase {

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
    TEST NO INSTANCE ON THE DATE (BAD HABIT INSTANCE)
    ****************************************************************************************/

    /** @test */
    public function has_a_bad_habit_instance_streak_of_zero_because_database_is_empty() {

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(0, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_zero_because_date_does_not_match_anything() {

    	$this->setUpBadHabit();

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(0, $badHabitInstanceStreak);
    }


    /****************************************************************************************
    TEST ONE INSTANCE (BAD HABIT INSTANCE)
    ****************************************************************************************/

    /** @test */
    public function has_a_bad_habit_instance_streak_of_one_because_of_exactly_one_success() {

    	$this->setUpBadHabit();

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(1, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_zero_because_of_exactly_one_fail_from_yesterday() {

    	$this->setUpBadHabit();

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(0, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_zero_because_of_exactly_one_fail_from_current_date() {

    	$this->setUpBadHabit();

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(0, $badHabitInstanceStreak);
    }


    /****************************************************************************************
    TEST MULTIPLE INSTANCES (BAD HABIT INSTANCES)
    ****************************************************************************************/

    /** @test */
    public function has_a_bad_habit_instance_streak_of_zero_because_yesterday_date_is_fail() {

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

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(0, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_three_because_no_break() {

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
            'is_success' => 1,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 4,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(3, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_zero_because_failed_on_current_date() {

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
            'is_success' => 1,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 4,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(0, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_two_because_of_break() {

    	$this->setUpBadHabit();

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-11'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-12'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 3,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-13'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 4,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 5,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(2, $badHabitInstanceStreak);
    }

    /** @test */
    public function has_a_bad_habit_instance_streak_of_three_because_of_break() {

    	$this->setUpBadHabit();

        factory(BadHabitInstance::class)->create([
        
            'id' => 1,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-10'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 2,
            'bad_habit_id' => 1,
            'is_success' => 0,
            'date' => '2017-02-11'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 3,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-12'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 4,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-13'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 5,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-14'
        ]);

        factory(BadHabitInstance::class)->create([
        
            'id' => 6,
            'bad_habit_id' => 1,
            'is_success' => 1,
            'date' => '2017-02-15'
        ]);

    	$currentDate = new \DateTime('2017-02-15');

    	$streakCalculator = new StreakCalculator;

    	$badHabitInstanceStreak = $streakCalculator->calculateBadHabitInstanceStreak($currentDate);

    	$this->assertEquals(3, $badHabitInstanceStreak);
    }
}
