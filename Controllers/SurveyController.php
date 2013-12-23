<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;

class SurveyController extends BaseController
{
    public function viewAction($surveyname)
    {
        echo $surveyname, PHP_EOL;
    }
}
