<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;
use Core\Http\Response\JsonResponse;

class AdminController extends BaseController
{
    public function indexAction()
    {
        $repo = $this->db->getRepository('Survey');
        $surveys = $repo->findAllGroupedByStatus();

        return $this->render('Admin::index', array(
            'surveys' => $surveys
        ), 'admin.html.php');
    }

    public function editAction($id)
    {
        $repo = $this->db->getRepository('Survey');

        $post = $this->request->post;
        if($this->request->isAjaxRequest() && !empty($post)) {
            //TODO forms
            //TODO validator
            $survey = $post->get('id') ? $repo->find($post->get('id')) : array();
            $survey['title'] = $post->get('title');

            return new JsonResponse(array('result' => true));
        }

        $survey = $repo->find($id);
        //TODO делать реквест на сервер чтоб получить уникальный идентификатор формы до того как она будет сохранена

        return $this->render('Admin::edit', array(
            'survey' => $survey
        ), 'admin.html.php');
    }
}
