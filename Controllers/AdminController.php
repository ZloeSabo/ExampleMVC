<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;

use Repository\SurveyRepository;

class AdminController extends BaseController
{
    public function indexAction()
    {
        $repo = $this->db->getRepository('Survey');
        $surveys = $repo->findAllGroupedByStatus();
        // var_dump($surveys); exit;

        return $this->render('Admin::index', array(
            'surveys' => $surveys
        ), 'admin.html.php');
    }
}
