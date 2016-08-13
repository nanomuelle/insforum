<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use AppBundle\Form\PostType;
use AppBundle\Entity\Post;

class DefaultControllerTest extends WebTestCase
{
    /**
    * Empty form should be ignored
    * -> no post added
    * -> no views increment
    */
    public function testEmptyForm() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $numPostsText = $crawler->filter('#numPosts')->text();
        $numViewsText = $crawler->filter('#numViews')->text();

        $form = $crawler->selectButton('Send')->form();
        $crawler = $client->submit($form);

        $this->assertEquals(
            $numPostsText,
            $crawler->filter('#numPosts')->text()
        );

        $this->assertEquals(
            $numViewsText,
            $crawler->filter('#numViews')->text()
        );
    }

    // public function testValidPngImage() {
    //     $imageName = 'image_ok.png';
    //     $imagePath = __DIR__ . '/../../Resources/testImages/';
    //     $uploadedImage = new UploadedFile($imagePath . $imageName, $imageName);
    //
    //     $client = static::createClient();
    //     $crawler = $client->request(
    //         'POST',
    //         '/',
    //         array('imageFile' => $uploadedImage ));
    //
    //     $numPostsText = $crawler->filter('#numPosts')->text();
    //     $this->assertEquals($numPostsText, "3");
    // }
    // public function testSubmitValidData() {
    //     $crawler = $client->click($crawler->selectLink('Upload')->link());
    //
    //     $imageName = 'image_ok.png';
    //     $imagePath = __DIR__ . '/../../Resources/testImages/';
    //
    //     $uploadedImage = new UploadedFile(
    //         $imagePath . $imageName,
    //         $imageName
    //     );
    //     $formData = array(
    //             'title' => 'Test tittle',
    //             'imageFile' => $uploadedImage
    //     );
    //
    //     $form = $this->factory->create(PostType::class);
    //     $post = new Post();
    //     $post->setTitle($formData['title']);
    //     $post->setImageOriginalName($imageName);
    //
    //     $form->submit($formData);
    //
    //     $this->assertTrue($form->isSynchronized());
    //     $this->assertEquals($post, $form->getData());
    //
    //     $view = $form->createView();
    //     $children = $view->children;
    //
    //     foreach (array_keys($formData) as $key) {
    //         $this->assertArrayHasKey($key, $children);
    //     }
    // }

    // public function testIndex()
    // {
    //     $client = static::createClient();
    //
    //     $crawler = $client->request('GET', '/');
    //
    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    //     $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    // }
    //
    // public function testUploadScenario()
    // {
    //     // Upload image
    //     $crawler = $client->click($crawler->selectLink('Upload')->link());
    //     $this->assertEquals(1, $crawler->filter('html:contains("Upload file attachment")')->count());
    //
    //     $pathToTestUploadFile = static::$kernel->getRootDir().'/../src/Acme/MyBundle/Resources/public/logo.gif';
    //
    //     $uploadForm = $crawler->selectButton('Upload')->form();
    //
    //     $uploadForm['upload[name]'] = "Logo Test";
    //     $uploadForm['upload[file]']->upload($pathToTestUploadFile);
    //
    //     $crawler = $client->submit($uploadForm);
    //
    //     // Check that the session flash message confirms the attachment was uploaded.
    //     $this->assertTrue($client->getResponse()->isSuccessful());
    //     $this->assertEquals(1, $crawler->filter('html:contains("File uploaded")')->count());
    //
    //     // Delete the image
    //     $crawler = $client->submit($crawler->selectButton('Delete')->form());
    //
    //     $this->assertEquals(0, $crawler->filter('html:contains("Logo Test")')->count());
    //     $this->assertEquals(1, $crawler->filter('html:contains("File has been deleted")')->count());
    // }
}
