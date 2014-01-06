<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;

use Repository\SurveyRepository;

class AdminController extends BaseController
{
    public function indexAction()
    {
        $repo = $this->db->getRepository('Survey');
        $surveyList = $repo->findAllGroupedByStatus();
        var_dump($surveyList); exit;

        return $this->render('Admin::index', array(
            'surveys' => 'testname'
        ));
    }
}
