<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WishControllerTest extends WebTestCase
{
    public function testWishListpageShowsAtLeastSomeWishes()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/wish');

        $this->assertResponseIsSuccessful();

        //on se positionne sur les balises articles
       $wishArticlesCount= $crawler->filter("li")->count();
       $this->assertGreaterThan(3, $wishArticlesCount, 'On devrait avoir au moins 3 wishes sur cette page!');
    }

    public function testCreateWishPageRedirectsToLog()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/profile/wish/create');

        //tester la redirection vers login si non connecte
        $this->assertResponseRedirects("/login",302);


    }

    public function testCreateWishPageIsSuccessfullWithLoggedUser()
    {
        $client = static::createClient();

        //appel au container de services pour acceder a ses methodes
        $userRepository = static::$container->get(UserRepository::class);
        $user = $userRepository->find(1);
        $client->loginUser($user);

        $crawler = $client->request('GET', '/profile/wish/create');

        $this->assertResponseIsSuccessful();


    }
}
