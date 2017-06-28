<?php

namespace base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="account", uniqueConstraints={@ORM\UniqueConstraint(name="email_uq", columns={"email"}), @ORM\UniqueConstraint(name="userName_uq", columns={"user_name"})})
 */
class Account {
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Company", inversedBy="accounts")
	 * @ORM\JoinColumn(name="id_company", referencedColumnName="id")
	 **/
	private $company;

	/**
	 * @ORM\ManyToOne(targetEntity="Country", inversedBy="accounts")
	 * @ORM\JoinColumn(name="id_country", referencedColumnName="id")
	 **/
	private $country;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;

	/**
	 * @ORM\Column(type="string", name="user_name")
	 */
	protected $userName;
	
	/**
	 * @ORM\Column(type="string", name="full_name", nullable=true)
	 */
	protected $fullName;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $address;
	
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected $city;
	
	/**
	 * @ORM\Column(type="boolean", name="is_active")
	 */
	protected $isActive;

	/**
	 * @ORM\Column(type="boolean", name="is_admin")
	 */
	protected $isAdmin;
	
	/**
	 * @ORM\Column(type="datetime", name="date_edit", nullable=true)
	 */
	protected $dateEdit;

    /**
     * @ORM\Column(type="datetime", name="date_create")
     */
    protected $dateCreate;

	/**
	 * @ORM\OneToMany(targetEntity="AccountAction", mappedBy="account")
	 */
	private $accountActions;

	/**
	 * @ORM\OneToMany(targetEntity="Employee", mappedBy="account")
	 */
	private $employees;
	
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
        $this->isActive = 0;
		$this->isAdmin  = 0;
		$this->accountActions = new ArrayCollection();
		$this->employees 	  = new ArrayCollection();
    }
	
	public function getId() {
		return $this->id;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getPassword() {
		return $this->password;
	}

	public function getUserName() {
		return $this->userName;
	}
	
	public function getFullName() {
		return $this->fullName;
	}
	
	public function getAddress() {
		return $this->address;
	}
	
	public function getCity() {
		return $this->city;
	}

	public function isActive() {
		return $this->isActive;
	}

    public function getCountryRow() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

    public function setIsActive($isActive) {
        $this->isActive = $isActive;
        return $this;
    }
	
	public function exchangeArray($data) {
        $this->email            = (isset ( $data ['email'] )) ? $data ['email'] : null;
        $this->userName         = (isset ( $data ['userName'] )) ? $data ['userName'] : null;
        $this->fullName         = (isset ( $data ['fullName'] )) ? $data ['fullName'] : null;
        $this->address          = (isset ( $data ['address'] )) ? $data ['address'] : null;
        $this->city             = (isset ( $data ['city'] )) ? $data ['city'] : null;
	}
}