<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace base\Controller;

use Illuminate\Auth\Passwords\PasswordResetServiceProvider;
use Zend\Mvc\Controller\AbstractActionController;
use base\Entity\Account;
use base\Entity\AccountAction;
use base\Form\LoginForm;
use base\Form\LoginFilter;
use base\Form\RegistrationForm;
use base\Form\RegistrationFilter;
use base\Form\PasswordRecoveryForm;
use base\Form\PasswordRecoveryFilter;
use base\Form\PasswordResetForm;
use base\Form\PasswordResetFilter;
use base\Library\Encryption;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Sendinblue\Mailin;

class AuthController extends AbstractActionController
{
    public function loginAction()
    {
        $this->layout('layout/login');

		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		if ($authService->hasIdentity()) {
			$authService->clearIdentity();
			$sessionManager = new \Zend\Session\SessionManager();
			$sessionManager->forgetMe();
		}
    	
		$form = new LoginForm();
		$registrationForm = new RegistrationForm($this->getEntityManager());
		$passwordRecoveryForm = new PasswordRecoveryForm();

		return new ViewModel(array(
			'form' 					=> $form,
			'registrationForm' 		=> $registrationForm,
			'passwordRecoveryForm' 	=> $passwordRecoveryForm
		));
    }

	public function proceedLoginAction()
	{
		$jsonModel = new JsonModel();
		$container = new Container('ci_reservation_system');
		$container->getManager()->getStorage()->clear('ci_reservation_system');
		$request = $this->getRequest();

		if ($request->isPost()) {
			$dataResult = array();
			$dataArr = $this->params()->fromPost('dataArr');

			foreach($dataArr as $data) {
				$dataResult[$data['name']] = trim($data['value']);
			}

			$form = new LoginForm();
			$form->setInputFilter(new LoginFilter($this->getServiceLocator()));
			$form->setData($dataResult);

			if ($form->isValid()) {
				$data = $form->getData();
				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['email']);
				$adapter->setCredentialValue($data['password']);
				$authResult = $authService->authenticate();
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
					$authService->getStorage()->write($identity);
					$time = 1209600;
					if($data['rememberMe']) {
						$sessionManager = new \Zend\Session\SessionManager();
						$sessionManager->rememberMe($time);
					}

					$jsonModel->setVariables(array(
						'success' => true
					));
				} else {
					$jsonModel->setVariables(array(
						'success' => false
					));
				}
			} else {
				$jsonModel->setVariables(array(
					'success' => false
				));
			}
		}

		return $jsonModel;
	}

    public function logoutAction()
    {
    	$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
    	$authService->clearIdentity();
    	$sessionManager = new \Zend\Session\SessionManager();
    	$sessionManager->forgetMe();
    	
    	return $this->redirect()->toRoute('login');
    }

	public function registrationAction()
	{
		$jsonModel = new JsonModel();
		$request = $this->getRequest();
		$form = new RegistrationForm($this->getEntityManager());

		if ($request->isPost()) {
			$dataResult = array();
			$dataArr = $this->params()->fromPost('dataArr');

			foreach($dataArr as $data) {
				$dataResult[$data['name']] = trim($data['value']);
			}

			$form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
			$form->setData($dataResult);

			if($form->isValid()) {
				$uri 			= $this->getRequest()->getUri();
				$entityManager 	= $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
				$baseUri 		= sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
				$data 			= $form->getData();
				$country 		= $entityManager->getRepository('base\Entity\Country')->findOneBy(array('id' => $data['country']));

				$account = new Account();
				$account->exchangeArray($data);
				$account->setCountry($country);
				$account->setPassword(Encryption::encrypt($data['password']));

				$token = md5(microtime());
				$accountActivation = new AccountAction();
				$accountActivation->setAccount($account);
				$accountActivation->setToken($token);
				$accountActivation->setIsActive(1);
				$accountActivation->setType('activation');

				$entityManager->persist($accountActivation);
				$entityManager->persist($account);
				$entityManager->flush();

				$mailin = new Mailin('https://api.sendinblue.com/v2.0', 'Dz9spX6LOkTjWgBG');

				$mailinTemplateData = array( "id" => 1,
					"to" => $data['email'],
					"attr" => array("EMAIL" => $data['email'], "TOKEN" => $token),
					"headers" => array("Content-Type"=> "text/html;charset=utf-8")
				);

				$mailin->send_transactional_template($mailinTemplateData);

				$jsonModel->setVariables(array(
					'success' => true
				));
			}
		}

		$jsonModel->setVariables(array(
			'formErrorMessagess' => $form->getMessages()
		));

		return $jsonModel;
	}

	public function activationAction() {
		$this->layout('layout/login');

		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		if ($authService->hasIdentity()) {
			$authService->clearIdentity();
			$sessionManager = new \Zend\Session\SessionManager();
			$sessionManager->forgetMe();
		}

		$email = $this->params()->fromRoute('email');
		$token = $this->params()->fromRoute('token');

		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$account = $entityManager->getRepository('base\Entity\Account')->findOneBy(array('email' => $email, 'isActive' => 0));

		if(!is_null($account)) {
			$accountActivation = $entityManager->getRepository('base\Entity\AccountAction')->findOneBy(array('account' => $account, 'type' => 'activation', 'isActive' => 1, 'token' => $token));

			if(!is_null($accountActivation)) {
				$account->setIsActive(1);
				$accountActivation->setIsActive(0);

				$entityManager->persist($account);
				$entityManager->persist($accountActivation);
				$entityManager->flush();

				return new ViewModel( array(
					'success' 	=> true,
					'msg' 		=> 'Gratulacje. Twoje konto jest już aktywne',
				));
			} else {
				return new ViewModel( array(
					'success' 	=> false,
					'msg' 		=> 'Przepraszamy. Nie można aktywować konta',
				));
			}
		} else {
			return new ViewModel( array(
				'success' 	=> false,
				'msg' 		=> 'Przepraszamy. Nie można aktywować konta',
			));
		}

		return new ViewModel();
	}

	public function passwordRecoveryAction()
	{
		$jsonModel = new JsonModel();
		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

		$uri = $this->getRequest()->getUri();
		$baseUri = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
		$token = null;
		$request = $this->getRequest();
		$form = new PasswordRecoveryForm();

		if($request->isXmlHttpRequest()) {
			if ($request->isPost()) {
				$dataResult = array();
				$dataArr = $this->params()->fromPost('dataArr');

				foreach($dataArr as $data) {
					$dataResult[$data['name']] = trim($data['value']);
				}

				$form->setInputFilter(new PasswordRecoveryFilter());
				$form->setData($dataResult);

				if($form->isValid()) {
					$account = $entityManager->getRepository('base\Entity\Account')->findOneBy(array('email' => $dataResult['email']));

					if (!is_null($account)) {
						$recoveryRows = $entityManager->getRepository('base\Entity\AccountAction')->findBy(array('account' => $account, 'type' => 'recovery', 'isActive' => 1));
						foreach ($recoveryRows as $row) {
							$row->setIsActive(0);
							$entityManager->persist($row);
						}

						$token = md5(microtime());
						$passwordRecovery = new AccountAction();
						$passwordRecovery->setAccount($account);
						$passwordRecovery->setToken($token);
						$passwordRecovery->setIsActive(1);
						$passwordRecovery->setType('recovery');
						$entityManager->persist($passwordRecovery);
						$entityManager->flush();

						$jsonModel->setVariables(array(
							'success' => true
						));
					}
				} else {
					$jsonModel->setVariables(array(
						'formErrorMessagess' => $form->getMessages()
					));
				}
			}
		} else {
			$this->getResponse()->setStatusCode(404);
			return;
		}

		return $jsonModel;
	}

	public function passwordResetAction()
	{
		$this->layout('layout/login');

		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		if ($authService->hasIdentity()) {
			$authService->clearIdentity();
			$sessionManager = new \Zend\Session\SessionManager();
			$sessionManager->forgetMe();
		}

		$form = new PasswordResetForm();
		$registrationForm = new RegistrationForm($this->getEntityManager());
		$request = $this->getRequest();

		$email = $this->params()->fromRoute('email');
		$token = $this->params()->fromRoute('token');

		$entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		$account = $entityManager->getRepository('base\Entity\Account')->findOneBy(array('email' => $email));

		if(!is_null($account)) {
			$accountAction = $entityManager->getRepository('base\Entity\AccountAction')->findOneBy(array('account' => $account, 'type' => 'recovery', 'isActive' => 1, 'token' => $token));

			if(!is_null($accountAction)) {
				if ($request->isPost()) {
					$form->setInputFilter(new PasswordResetFilter($this->getServiceLocator()));
					$form->setData($request->getPost());

					if($form->isValid()) {
						$data = $form->getData();
						$account->setPassword(Encryption::encrypt($data['password']));
						$accountAction->setIsActive(0);
						$entityManager->persist($account);
						$entityManager->persist($accountAction);
						$entityManager->flush();

						return new ViewModel(array(
							'success' => true,
							'form' => $form,
							'registrationForm' => $registrationForm
						));
					} else {
						return new ViewModel(array(
							'form' => $form,
							'registrationForm' => $registrationForm
						));
					}
				}
			} else {
				return new ViewModel(array(
					'error' => 'Nie można zmienić hasła dla tego konta',
					'form' => $form,
					'registrationForm' => $registrationForm
				));
			}
		} else {
			return new ViewModel(array(
				'error' => 'Nie można zmienić hasła dla tego konta',
				'form' => $form,
				'registrationForm' => $registrationForm
			));
		}

		return new ViewModel(array (
			'form' => $form,
			'registrationForm' => $registrationForm
		));
	}
}
