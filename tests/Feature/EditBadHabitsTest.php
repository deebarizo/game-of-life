<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\BadHabit;

class EditBadHabitsTest extends TestCase
{
	/** @test */
    public function anyone_can_edit_a_bad_habit()
    {
        $badHabit = factory('App\BadHabit')->create([
        	'id' => 1,
        	'name' => 'Do Not Smoke',
			'description' => 'Test description',
            'is_success' => 0,
        ]);

        $newBadHabit = factory('App\BadHabit')->make([
        	'id' => 1,
        	'name' => 'Do Not Drink',
			'description' => 'Test description but different',
            'is_success' => 1,
        ]);

        $response = $this->put($badHabit->path(), $newBadHabit->toArray());

        $badHabit = BadHabit::find(1);

        $this->assertEquals($badHabit->name, 'Do Not Drink');
        $this->assertEquals($badHabit->description, 'Test description but different');
        $this->assertEquals($badHabit->is_success, 1);
    }

    /** @test */
    public function use_old_image_url_if_a_new_image_is_not_uploaded()
    {
        $badHabit = factory('App\BadHabit')->create([
            'id' => 1,
            'image_url' => 'files/images/fish.png'
        ]);

        $newBadHabit = factory('App\BadHabit')->make([
            'id' => 1,
            'image_url' => null
        ]);

        $response = $this->put($badHabit->path(), $newBadHabit->toArray());

        $badHabit = BadHabit::find(1);

        $this->assertEquals($badHabit->image_url, 'files/images/fish.png');
    }
}
