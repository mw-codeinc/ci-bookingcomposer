<?php
namespace base\Form\Validator;

use Zend\Validator\AbstractValidator;

class Password extends AbstractValidator {

	const PASSWORD_UPPERCASE_INVALID 	= 'invalidPasswordUppercaseRegex';
	const PASSWORD_DIGIT_INVALID 		= 'invalidPasswordDigitRegex';

	protected $messageTemplates = array(
		self::PASSWORD_UPPERCASE_INVALID => "Hasło musi zawierać przynajmniej jedną wielką literę",
		self::PASSWORD_DIGIT_INVALID => "Hasło musi zawierać przynajmniej jedną cyfrę"
	);

	public function isValid($value)
	{
		$this->setValue($value);

		if(!preg_match('/[A-Z]+/', $value)) {
			$this->error(self::PASSWORD_UPPERCASE_INVALID);
		}

		if(!preg_match('/[\d!$%^&]+/', $value)) {
			$this->error(self::PASSWORD_DIGIT_INVALID);
		}

		if(!empty($this->getMessages())) {
			return false;
		}

		return true;
	}
}