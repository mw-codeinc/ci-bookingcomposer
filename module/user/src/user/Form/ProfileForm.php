<?php

namespace user\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;

class ProfileForm extends Form
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);

        parent::__construct('profile');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'profile-form');

        $this->add(array(
            'name' => 'fullName',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Imię i Nazwisko'
            ),
            'options' => array(
                'label' => 'Imię i Nazwisko',
            )
        ));
        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            	'class' => 'form-control placeholder-no-fix',
            	'placeholder' => 'Email'
            ),
            'options' => array(
                'label' => 'Email',
            )
        ));
        $this->add(array(
            'name' => 'address',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Adres'
            ),
            'options' => array(
                'label' => 'Adres',
            )
        ));
        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Miasto'
            ),
            'options' => array(
                'label' => 'Miasto',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'country',
            'attributes' => array(
                'id'    => 'countrySelect',
                'class' => 'select2 form-control'
            ),
            'options' => array(
                'label' => 'Kraj',
                'value_options' => $this->getCountryForSelectArr()
            )
        ));
        $this->add(array(
            'name' => 'userName',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Nazwa użytkownika'
            ),
            'options' => array(
                'label' => 'Nazwa Użytkownika',
            )
        ));
    }

    private function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
        return $this;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

    public function getCountryForSelectArr() {
        $rowset = $this->getObjectManager()->getRepository('base\Entity\Country')->findAll();
        $valueOptionsArr = array();
        foreach($rowset as $row) {
            $valueOptionsArr[$row->getId()] = $row->getName();
        }
        return $valueOptionsArr;
    }

    public function getCountryArr() {
        $rowset = $this->getObjectManager()->getRepository('base\Entity\Country')->findAll();
        $valueOptionsArr = array();
        foreach($rowset as $row) {
            $valueOptionsArr[$row->getId()] = array('name' => $row->getName(), 'code' => $row->getCode());
        }
        return $valueOptionsArr;
    }
}