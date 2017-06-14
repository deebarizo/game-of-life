<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\BadHabit;

class CreateBadHabitsTest extends TestCase
{
	/** @test */
    public function anyone_can_create_a_bad_habit()
    {
        $badHabit = factory('App\BadHabit')->make([
        	'id' => 1, 
        	'name' => 'Do Not Smoke',
        	'description' => 'Test description',
            'image_url' => null, // this is needed because we are posting an http request and the method uses the FileUploader use case
            'is_success' => 0
        ]);

        $this->post('/bad_habits', $badHabit->toArray());

        $badHabit = BadHabit::find(1);

        $this->assertEquals($badHabit->name, 'Do Not Smoke');
        $this->assertEquals($badHabit->description, 'Test description');
        $this->assertEquals($badHabit->is_success, 0);
    }

    /** @test */
    public function use_default_image_if_image_is_not_given()
    {
        $badHabit = factory('App\BadHabit')->make([
            'image_url' => null
        ]);

        $this->post('/bad_habits', $badHabit->toArray());

        $badHabit = BadHabit::find(1);

        $this->assertEquals($badHabit->image_url, 'files/images/experiment.png');
    }
}
