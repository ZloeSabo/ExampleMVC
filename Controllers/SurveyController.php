<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;

class SurveyController extends BaseController
{
    public function indexAction()
    {
        // $sql = $this->db->getConnection();
        // $sql->query('SELECT * FROM Survey');
        // var_dump($sql->query('SELECT * FROM Survey'));
        // var_dump($sql);
        echo "index";
        exit;
    }

    public function viewAction($surveyname)
    {
        return $this->render('Survey::view', array(
            'name' => 'testname'
        ));
    }
}
