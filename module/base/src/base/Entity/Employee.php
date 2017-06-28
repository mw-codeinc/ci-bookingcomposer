<?php

namespace base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="employee")
 */
class Employee {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Account", inversedBy="employees")
	 * @ORM\JoinColumn(name="id_account", referencedColumnName="id")
	 **/
	private $account;

	/**
	 * @ORM\ManyToOne(targetEntity="Company", inversedBy="employees")
	 * @ORM\JoinColumn(name="id_company", referencedColumnName="id")
	 **/
	private $company;
	
	/**
	 * @ORM\Column(type="datetime", name="date_edit", nullable=true)
	 */
	protected $dateEdit;

    /**
     * @ORM\Column(type="datetime", name="date_create")
     */
    protected $dateCreate;
	
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
    }

	public function getId() {
		return $this->id;
	}
	
	public function getAccountRow() {
		return $this->account;
	}

	public function getCompanyRow() {
		return $this->company;
	}
}