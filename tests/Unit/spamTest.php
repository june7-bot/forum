<?php

namespace Tests\Feature;

use App\Inspections\Spam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class spamTest extends TestCase
{
    use RefreshDatabase;

    public function test_checks_for_invalid_keywords()
    {

        $spam = new Spam();

        self::assertFalse( $spam->detect('Innocent reply'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');

    }

    function test_checks_for_any_Key_belong_held_down()
    {
        $spam = new Spam();

        $this->expectException('Exception');


        $spam->detect('hello word aaaaaaaaaaaaaaa');


    }
}
