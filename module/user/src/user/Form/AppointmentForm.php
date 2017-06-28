<?php

namespace user\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;

class AppointmentForm extends Form
{
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->setObjectManager($objectManager);

        parent::__construct('appointment');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'profile-form');

        $this->add(array(
            'name' => 'appointmentName',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Nazwa zabiegu*'
            ),
            'options' => array(
                'label' => 'Nazwa zabiegu',
            )
        ));
        $this->add(array(
            'name' => 'appointmentTime',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Czas wizyty*'
            ),
            'options' => array(
                'label' => 'Czas wizyty',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'room',
            'attributes' => array(
                'id'    => 'roomSelect',
                'class' => 'select2 form-control'
            ),
            'options' => array(
                'label' => 'Kraj',
                'value_options' => $this->getRoomForSelectArr()
            )
        ));
        $this->add(array(
            'name' => 'clientFullName',
            'attributes' => array(
                'type'  => 'text',
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Imię i Nazwisko*'
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
            'type' => 'Zend\Form\Element\Select',
            'name' => 'employee',
            'attributes' => array(
                'id'    => 'employeeSelect',
                'class' => 'select2 form-control'
            ),
            'options' => array(
                'label' => 'Kraj',
                'value_options' => $this->getEmployeeForSelectArr()
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

    public function getEmployeeForSelectArr() {
        $rowset = $this->getObjectManager()->getRepository('base\Entity\Employee')->findAll();
        $valueOptionsArr = array();
        foreach($rowset as $row) {
            $valueOptionsArr[$row->getId()] = $row->getAccountRow()->getFullName();
        }
        return $valueOptionsArr;
    }

    public function getRoomForSelectArr() {
        $rowset = $this->getObjectManager()->getRepository('base\Entity\Room')->findAll();
        $valueOptionsArr = array();
        foreach($rowset as $row) {
            $valueOptionsArr[$row->getId()] = $row->getName();
        }
        return $valueOptionsArr;
    }
}