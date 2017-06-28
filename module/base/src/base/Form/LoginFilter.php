<?php
namespace base\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
	public function __construct($sm)
	{
		$this->add(array(
			'name'     => 'email',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
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
					'name' => 'DoctrineModule\Validator\ObjectExists',
					'options' => array(
						'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('base\Entity\Account'),
						'fields'            => 'email',
						'message'			=> 'Błędny email lub hasło'
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
		$this->add(array(
			'name'     => 'password',
			'required' => true,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
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
						'encoding' => 'UTF-8',
						'min'      => 8,
						'max'      => 250,
						'messages' => array(
							\Zend\Validator\StringLength::TOO_SHORT => 'Błędny email lub hasło',
							\Zend\Validator\StringLength::TOO_LONG => 'Błędny email lub hasło'
						)
					),
				),
				array (
					'name' => 'base\Form\Validator\Password',
					'options' => array(
						'messages' => array(
							\base\Form\Validator\Password::PASSWORD_UPPERCASE_INVALID => 'Błędny email lub hasło',
							\base\Form\Validator\Password::PASSWORD_DIGIT_INVALID => 'Błędny email lub hasło'
						)
					)
				)
			),
		));
		$this->add(array(
			'name'     => 'rememberMe',
			'required' => false,
			'filters'  => array(
				array('name' => 'StripTags'),
				array('name' => 'StringTrim')
			)
		));
	}
}