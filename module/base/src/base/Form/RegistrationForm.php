<?php

namespace base\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;

class RegistrationForm extends Form
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);

        parent::__construct('registration');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'register-form');

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
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control placeholder-no-fix',
            	'placeholder' => 'Hasło',
                'autocomplete' => 'off'
            ),
            'options' => array(
                'label' => 'Hasło',
            )
        ));
        $this->add(array(
            'name' => 'rePassword',
            'attributes' => array(
                'type'  => 'password',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Powtórz Hasło',
                'autocomplete' => 'off'
            ),
            'options' => array(
                'label' => 'Powtórz Hasło',
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