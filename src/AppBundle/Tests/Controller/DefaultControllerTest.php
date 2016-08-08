<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testUploadScenario()
    {
        // Upload image
        $crawler = $client->click($crawler->selectLink('Upload')->link());
        $this->assertEquals(1, $crawler->filter('html:contains("Upload file attachment")')->count());

        $pathToTestUploadFile = static::$kernel->getRootDir().'/../src/Acme/MyBundle/Resources/public/logo.gif';

        $uploadForm = $crawler->selectButton('Upload')->form();

        $uploadForm['upload[name]'] = "Logo Test";
        $uploadForm['upload[file]']->upload($pathToTestUploadFile);

        $crawler = $client->submit($uploadForm);

        // Check that the session flash message confirms the attachment was uploaded.
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter('html:contains("File uploaded")')->count());

        // Delete the image
        $crawler = $client->submit($crawler->selectButton('Delete')->form());

        $this->assertEquals(0, $crawler->filter('html:contains("Logo Test")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("File has been deleted")')->count());
    }
}
