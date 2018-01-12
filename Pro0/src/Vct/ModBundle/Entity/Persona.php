<?php

namespace Vct\ModBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persona
 *
 * @ORM\Table(name="personas")
 * @ORM\Entity(repositoryClass="Vct\ModBundle\Repository\PersonaRepository")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Persona
{
    /**
     * @ORM\OneToMany(targetEntity="Telefono", mappedBy="person")
     * 
    */
    protected $tel;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apPaterno", type="string", length=100)
     */
    private $apPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apMaterno", type="string", length=100)
     */
    private $apMaterno;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;


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
     * Set nombre
     *
     * @param string $nombre
     * @return Persona
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apPaterno
     *
     * @param string $apPaterno
     * @return Persona
     */
    public function setApPaterno($apPaterno)
    {
        $this->apPaterno = $apPaterno;

        return $this;
    }

    /**
     * Get apPaterno
     *
     * @return string 
     */
    public function getApPaterno()
    {
        return $this->apPaterno;
    }

    /**
     * Set apMaterno
     *
     * @param string $apMaterno
     * @return Persona
     */
    public function setApMaterno($apMaterno)
    {
        $this->apMaterno = $apMaterno;

        return $this;
    }

    /**
     * Get apMaterno
     *
     * @return string 
     */
    public function getApMaterno()
    {
        return $this->apMaterno;
    }    

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Persona
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Persona
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

    /* Se crean como valor inicial la fecha y tiempo*/
    /**
    * @ORM\PrePersist
    */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
    * @ORM\PrePersist
    * @ORM\PreUpdate
    */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    public function __construct()
    {
        $this->tel = new ArrayCollection();
    }
    

    /**
     * Add tel
     *
     * @param \Vct\ModBundle\Entity\Telefono $tel
     * @return Persona
     */
    public function addTel(\Vct\ModBundle\Entity\Telefono $tel)
    {
        $this->tel[] = $tel;

        return $this;
    }

    /**
     * Remove tel
     *
     * @param \Vct\ModBundle\Entity\Telefono $tel
     */
    public function removeTel(\Vct\ModBundle\Entity\Telefono $tel)
    {
        $this->tel->removeElement($tel);
    }

    /**
     * Get tel
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTel()
    {
        return $this->tel;
    }
}
