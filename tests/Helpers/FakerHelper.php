<?php

namespace App\Tests\Helpers;

use Faker\Factory;
use Faker\Generator;

trait FakerHelper
{
    public function getFaker(): Generator
    {
        return Factory::create();
    }
}