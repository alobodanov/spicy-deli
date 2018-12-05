<?php

namespace App\DataFixtures\Faker\Provider;

use Faker\Provider\Base;

class ProductProvider extends Base
{
    public static function setCategory($product)
    {
        if ($product === 'sik') {
            return 'Ethiopia, Meat, Beef, Chili pepper';
        } else if ($product === 'huo') {
            return 'China, Meat, Beef, Fish, Tofu, Sichuan pepper';
        } else {
            return 'Peru, Potato, Yellow Chili pepper';
        }
    }
}