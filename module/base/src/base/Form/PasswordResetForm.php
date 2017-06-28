<?php

namespace base\Form;

use Zend\Form\Form;

class PasswordResetForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('passwordReset');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            	'class' => 'form-control',
            	'placeholder' => 'Nowe Hasło'
            ),
            'options' => array(
                'label' => 'Nowe Hasło'
            )
        ));

        $this->add(array(
        	'name' => 'rePassword',
        	'attributes' => array(
        		'type'  => 'password',
        		'class' => 'form-control',
        		'placeholder' => 'Powtórz Hasło'
            ),
        	'options' => array(
        		'label' => 'Powtórz Hasło'
            )
        ));
    }
}