<?php

namespace App\Tests;

use App\Services\Censurator;
use PHPUnit\Framework\TestCase;


//herite d'une class de phpunit
class CensuratorTest extends TestCase
{
    //test unitaire
    public function testCensuratorCensurateBadWords()
    {

        $censurator = new Censurator();
        //on indique une phrase de test
        $result =$censurator->purify("l'argent fait le bonheur");
        //asserEquals prend en parametre ce qu'on s'attend a recevoir et ce qu'on a reçu et compare
        $this->assertEquals("l'* fait le bonheur", $result);

    }
}
