<?php

namespace base\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'login-form');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            	'class' => 'form-control placeholder-no-fix',
            	'placeholder' => 'Email'
            ),
            'options' => array(
                'label' => 'Email'
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
                'label' => 'Hasło'
            )
        ));
        $this->add(array(
            'name' => 'rememberMe',
            'type' => 'Zend\Form\Element\Checkbox',
            'options' => array(
                'label' => 'Zapamiętaj mnie'
            )
        ));
    }
}