<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use AppBundle\Form\PostType;
use AppBundle\Entity\Post;

class DefaultControllerTest extends WebTestCase
{
    public function testOverResolutionImage() {
        $imageName = 'over_resolution_image.jpg';
        $imagePath = __DIR__ . '/../../Resources/testImages/';
        $uploadedImage = new UploadedFile($imagePath . $imageName, $imageName);

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Send')->form();
        $form['post[title]'] = "Over resolution image test";
        $form['post[imageFile]']->upload($imagePath . $imageName);

        $crawler = $client->submit($form);
        $this->assertEquals(
            1,
            $crawler->filter('html:contains("The image width is too big")')->count());
    }

    public function testOverSizedImage() {
        $imageName = 'more_than_2M_image.jpg';
        $imagePath = __DIR__ . '/../../Resources/testImages/';
        $uploadedImage = new UploadedFile($imagePath . $imageName, $imageName);

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Send')->form();
        $form['post[title]'] = "Over sized image test";
        $form['post[imageFile]']->upload($imagePath . $imageName);

        $crawler = $client->submit($form);
        $this->assertEquals(
            1,
            $crawler->filter('html:contains("The file is too large")')->count());

    }
}
