<?php
namespace base\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class PasswordRecoveryFilter extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name'     => 'email',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim'),
			),
			'validators' => array(
				array(
					'name' =>'NotEmpty',
					'options' => array(
						'messages' => array(
							\Zend\Validator\NotEmpty::IS_EMPTY => 'Pole jest wymagane'
						)
					)
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					)
				),
				array(
					'name' => 'EmailAddress',
					'options' => array(
						'message' => 'Format adresu email jest niepoprawny'
					)
				)
			),
		));
	}
}