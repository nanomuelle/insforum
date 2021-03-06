<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
* @ORM\Entity
* @ORM\Table(name="view")
*/
class View
{
  /**
  * @ORM\Column(type="integer")
  * @ORM\id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  private $id;

  /**
   * @ORM\Column(type="integer")
   */
  private $count;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function incrementCount() {
        $this->count++;
    }
    
    /**
     * Set count
     *
     * @param integer $count
     * @return View
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }
}
