<?php

namespace Tests\UseCases;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Option;

use App\UseCases\DateCalculator;

class DateCalculatorTest extends TestCase {

	use DatabaseTransactions;


	/****************************************************************************************
	TEST OPTION WITH ZERO START TIME
	****************************************************************************************/

    private function setUpZeroStartTime() {

        factory(Option::class)->create([
        
            'id' => 1,
            'start_time' => 0,
            'end_time' => 24
        ]);
    }

    /** @test */
    public function returns_same_date() {

    	$this->setUpZeroStartTime();

        $date = new \DateTime('2017-02-13');

        $dateCalculator = new DateCalculator;
        
        $currentDate = $dateCalculator->getCurrentDate($optionId = 1, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-13');
    }


	/****************************************************************************************
	TEST OPTION WITH NEGATIVE START TIME
	****************************************************************************************/

    private function setUpNegativeStartTime() {

        factory(Option::class)->create([
        
            'id' => 1,
            'start_time' => -8,
            'end_time' => 16
        ]);
    }

    /** @test */
    public function returns_same_date_because_less_than() {

        $this->setUpNegativeStartTime();

        $date = new \DateTime('2017-02-13');
        $date->setTime(15, 0); // 15 < 24 + -8

        $dateCalculator = new DateCalculator;
        
        $currentDate = $dateCalculator->getCurrentDate($optionId = 1, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-13');
    }

    /** @test */
    public function returns_next_date_because_greater_than() {

        $this->setUpNegativeStartTime();

        $date = new \DateTime('2017-02-13');
        $date->setTime(22, 0); // 22 > 24 + -8

        $dateCalculator = new DateCalculator;
        
        $currentDate = $dateCalculator->getCurrentDate($optionId = 1, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-14');
    }

    /** @test */
    public function returns_next_date_because_equals() {

        $this->setUpNegativeStartTime();

        $date = new \DateTime('2017-02-13');
        $date->setTime(16, 0); // 16 = 24 + -8

        $dateCalculator = new DateCalculator;
        
        $currentDate = $dateCalculator->getCurrentDate($optionId = 1, $date);

        $this->assertContains($currentDate->format('Y-m-d'), '2017-02-14');
    }
}