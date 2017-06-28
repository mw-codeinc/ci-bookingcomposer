<?php

namespace base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="country")
 */
class Country {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $code;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="datetime", name="date_edit", nullable=true)
	 */
	protected $dateEdit;

	/**
	 * @ORM\Column(type="datetime", name="date_create")
	 */
	protected $dateCreate;

    /**
     * @ORM\OneToMany(targetEntity="Account", mappedBy="country")
     */
    private $accounts;

	/**
	 * @ORM\PrePersist
	 */
	public function setDateCreate() {
		$this->dateCreate = new \DateTime();
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function setDateEdit() {
		$this->dateEdit = new \DateTime();
	}

	public function __construct() {
		$this->accounts = new ArrayCollection();
	}
    
    public function getId() {
    	return $this->id;
    }
    
    public function getCode() {
    	return $this->code;
    }
    
    public function getName() {
    	return $this->name;
    }
}