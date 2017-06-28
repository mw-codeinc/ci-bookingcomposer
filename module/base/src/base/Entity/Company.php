<?php

namespace base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="company")
 */
class Company {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
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
	 * @ORM\OneToMany(targetEntity="Account", mappedBy="company")
	 */
	private $accounts;

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="company")
	 */
	private $employees;

	/**
	 * @ORM\OneToMany(targetEntity="Room", mappedBy="company")
	 */
	private $rooms;
	
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
		$this->accounts  = new ArrayCollection();
		$this->employees = new ArrayCollection();
		$this->rooms 	 = new ArrayCollection();
    }
	
	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->userName;
	}
}