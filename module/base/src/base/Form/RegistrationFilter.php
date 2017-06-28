<?php
namespace base\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class RegistrationFilter extends InputFilter
{
	public function __construct($sm)
	{
		$this->add(array(
			'name'     => 'fullName',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					),
				)
			)
		));
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					),
				),
				array(
					'name' => 'DoctrineModule\Validator\NoObjectExists',
					'options' => array(
						'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('base\Entity\Account'),
						'fields'            => 'email',
						'message'			=> 'Konto do którego przypisane ten email już istnieje. Proszę użyć innego adresu email lub zalogować się'
					),
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
			'name'     => 'address',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					),
				)
			)
		));
		$this->add(array(
			'name'     => 'city',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					),
				)
			)
		));
		$this->add(array(
			'name'     => 'country',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					),
				)
			)
		));
		$this->add(array(
			'name'     => 'userName',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8'
					),
				),
				array(
					'name' => 'DoctrineModule\Validator\NoObjectExists',
					'options' => array(
						'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('base\Entity\Account'),
						'fields'            => 'userName',
						'message'			=> 'Taki użytkownik już instnieje. Proszę użyć innej nazwy użytkownika'
					),
				),
			)
		));
		$this->add(array(
			'name'     => 'password',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min'      => 8,
						'max'      => 250,
						'messages' => array(
							\Zend\Validator\StringLength::TOO_SHORT => 'Hasło musi mieć conajmniej 8 znaków',
							\Zend\Validator\StringLength::TOO_LONG => 'Hasło nie może przekraczać 250 znaków'
						)
					),
				),
				array (
					'name' => 'base\Form\Validator\Password',
				)
			),
		));
		$this->add(array(
			'name'     => 'rePassword',
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
						),
					),
				),
				array(
					'name'    => 'StringLength',
					'options' => array(
						'encoding' => 'UTF-8',
						'min'      => 8,
						'max'      => 250,
						'messages' => array(
							\Zend\Validator\StringLength::TOO_SHORT => 'Hasło musi mieć conajmniej 8 znaków',
							\Zend\Validator\StringLength::TOO_LONG => 'Hasło nie może przekraczać 250 znaków'
						)
					),
				),
				array (
					'name' => 'base\Form\Validator\Password',
				),
				array(
					'name'    => 'Identical',
					'options' => array(
						'token' => 'password',
						'message' => 'Podane hasła nie są identyczne'
					)
				)
			),
		));
	}
}