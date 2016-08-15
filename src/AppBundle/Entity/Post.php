<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity(repositoryClass="AppBundle\Entity\PostRepository")
* @ORM\Table(name="post")
* @Vich\Uploadable
*/
class Post
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
  * @ORM\Column(type="string", length=255, nullable=true)
  * @var string;
  */
  private $title;

  /**
  * @ORM\Column(type="string", length=2048)
  * @var string;
  */
  private $imageOriginalName;

  /**
  * @ORM\Column(type="string", length=255)
  * @var string;
  */
  private $imageName;

  /**
  * https://github.com/dustin10/VichUploaderBundle/blob/master/Resources/doc/usage.md
  * @Vich\UploadableField(mapping="post_image", fileNameProperty="imageName")
  * @Assert\Image(
  *     maxWidth = 1920,
  *     maxHeight = 1080,
  *     maxSize = "2048k",
  *     mimeTypes = {"image/jpeg", "image/jpg", "image/png", "image/gif"}
  * )
  *
  * @var File
  */
  private $imageFile;

  /**
  * @ORM\Column(type="datetime")
  * @var \DateTime
  */
  private $updatedAt;

  /**
   * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
   * of 'UploadedFile' is injected into this setter to trigger the  update. If this
   * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
   * must be able to accept an instance of 'File' as the bundle will inject one here
   * during Doctrine hydration.
   *
   * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
   *
   * @return Product
   */
  public function setImageFile(File $image = null)
  {
      $this->imageFile = $image;

      if ($image) {
          // It is required that at least one field changes if you are using doctrine
          // otherwise the event listeners won't be called and the file is lost
          $this->updatedAt = new \DateTime('now');
      }

      return $this;
  }

  /**
   * @return File
   */
  public function getImageFile()
  {
      return $this->imageFile;
  }

  /**
   * @param string $imageName
   *
   * @return Product
   */
  public function setImageName($imageName)
  {
      $this->imageName = $imageName;

      return $this;
  }

  /**
   * @return string
   */
  public function getImageName()
  {
      return $this->imageName;
  }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set imageOriginalName
     *
     * @param string $imageOriginalName
     * @return Post
     */
    public function setImageOriginalName($imageOriginalName)
    {
        $this->imageOriginalName = $imageOriginalName;

        return $this;
    }

    /**
     * Get imageOriginalName
     *
     * @return string
     */
    public function getImageOriginalName()
    {
        return $this->imageOriginalName;
    }
}
