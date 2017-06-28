<?php

namespace base\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="account_action")
 */
class AccountAction implements InputFilterAwareInterface {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="accountActions")
     * @ORM\JoinColumn(name="id_account", referencedColumnName="id")
     **/
    private $account;
    
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $type;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $token;

    /**
     * @ORM\Column(type="boolean", name="is_active", nullable=true)
     */
    protected $isActive;
    
    /**
     * @ORM\Column(type="datetime", name="date_create")
     */
    protected $dateCreate;

    protected $inputFilter;

    /**
     * @ORM\PrePersist
     */
    public function setDateCreate() {
        $this->dateCreate = new \DateTime();
    }

    public function setAccount($account) {
    	$this->account = $account;
    	return $this;
    }

    public function setToken($token) {
    	$this->token = $token;
    	return $this;
    }

    public function setType($type) {
    	$this->type = $type;
    	return $this;
    }

    public function setIsActive($isActive) {
    	$this->isActive = $isActive;
    	return $this;
    }
    
    public function getId() {
    	return $this->id;
    }
    
    public function getType() {
    	return $this->type;
    }

    public function getToken() {
        return $this->token;
    }

    public function isActive() {
        return $this->isActive;
    }
    
    public function getAccountRow() {
    	return $this->account;
    }

    public function exchangeArray($data) {
        $this->type     = (isset ( $data ['type'] )) ? $data ['type'] : null;
        $this->token    = (isset ( $data ['token'] )) ? $data ['token'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {}

    public function getInputFilter() {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter ();
            $factory = new InputFactory ();

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}