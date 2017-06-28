<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace user\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use user\Form\ProfileForm;

class ProfileController extends AbstractActionController
{
    public function viewAction()
    {
        $this->getServiceLocator()->get('viewhelpermanager')->get('headLink')->appendStylesheet('/css/user/profile/view.css');
        $this->getServiceLocator()->get('viewhelpermanager')->get('inlineScript')->appendFile('/js/user/profile/view.js');

        $form = new ProfileForm($this->getEntityManager());

        return array(
            'form' => $form
        );
    }

    public function updateAction() {

    }
}