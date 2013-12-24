<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;

class SurveyController extends BaseController
{
    public function viewAction($surveyname)
    {
        return $this->render('Survey::view', array(
            'name' => 'testname'
        ));
    }
}
