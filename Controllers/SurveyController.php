<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;

class SurveyController extends BaseController
{
    public function indexAction()
    {
        $repo = $this->get('db')->getRepository('Survey');
        $active = $repo->findActive();

        return $this->render('Survey::index', array(
            'active' => $active
        ));
    }

    public function viewAction($surveyname)
    {
        return $this->render('Survey::view', array(
            'name' => 'testname'
        ));
    }

    public function editAction()
    {
        
    }
}
