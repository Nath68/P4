<?php
/**
 * Created by PhpStorm.
 * User: nduvi
 * Date: 03/11/2017
 * Time: 09:26
 */

namespace ML\billetterieBundle\Tests\Controller;

use ML\billetterieBundle\Controller\BilletterieController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/billetterie/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Billetterie du Musée du Louvre', $crawler->filter('h1')->text());
    }
}