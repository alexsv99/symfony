<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testBuildAssignsParamsToTheCorrectFields()
    {
        $testRow = [
            'name' => 'Yoda',
            'height' => 66,
            'mass' => 13,
            'hair_color' => 'silver',
            'skin_color' => 'green',
            'eye_color' => 'black',
            'birth_year' => '896BBY',
            'gender' => 'male',
        ];

        $result = Client::build($testRow);

        $this->assertEquals($testRow['name'], $result->getName());
        $this->assertEquals($testRow['height'], $result->getHeight());
        $this->assertEquals($testRow['mass'], $result->getMass());
        $this->assertEquals($testRow['hair_color'], $result->getHairColor());
        $this->assertEquals($testRow['skin_color'], $result->getSkinColor());
        $this->assertEquals($testRow['eye_color'], $result->getEyeColor());
        $this->assertEquals($testRow['birth_year'], $result->getBirthYear());
        $this->assertEquals($testRow['gender'], $result->getGender());
    }
}
