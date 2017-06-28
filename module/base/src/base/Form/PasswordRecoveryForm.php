<?php

namespace base\Form;

use Zend\Form\Form;

class PasswordRecoveryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('passwordRecovery');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'forget-form');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type'  => 'text',
            	'class' => 'form-control placeholder-no-fix',
            	'placeholder' => 'Email',
                'autocomplete' => 'off'
            ),
            'options' => array(
                'label' => 'Email',
            )
        ));
    }
}