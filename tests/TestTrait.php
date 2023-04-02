<?php

namespace Tests;

use App\Models\User;

trait TestTrait
{
    public function setUpTesting($login = true)
    {
        parent::setUp();

        $user = User::factory(1)->create();

    }


    abstract function model();
}
