<?php

namespace AppBundle\Tests\Form\Type;

use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use AppBundle\Form\PostType;
use AppBundle\Entity\Post;

class PostTypeTest extends TypeTestCase
{
    public function testSubmitValidData() {
        $imageName = 'image_ok.png';
        $imagePath = __DIR__ . '/../../../Resources/testImages/';

        $uploadedImage = new UploadedFile(
            $imagePath . $imageName,
            $imageName
        );

        $formData = array(
                'title' => 'Test tittle',
                'imageFile' => $uploadedImage
        );

        $form = $this->factory->create(PostType::class);
        $post = new Post();
        $post->setTitle($formData['title']);
        $post->setImageFile($uploadedImage);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($post, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
