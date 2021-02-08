<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomePageIsDoingOk()
    {
        //creation d'un client pour pouvoir faire des requetes http
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        //verifie qu'on reçoit une reponse de type 200 =succes
        $this->assertResponseIsSuccessful();
        //verifie qu'il y a un h1 qui contient...+3eme parametre ajouter un message d'erreur plus lisible
        $this->assertSelectorTextContains('h1', 'Bucket-List. Faîtes la liste de vos envies','devrait avoir pour titre:...');
    }


    public function testAboutUsIsDoingOk()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about-us/');

        //verifie qu'on reçoit une reponse de type 200 =succes
        $this->assertResponseIsSuccessful();
        //verifie qu'il y a un h1 qui contient...
        $this->assertSelectorTextContains('h1', 'Bucket-List. Faîtes la liste de vos envies');
    }
}
