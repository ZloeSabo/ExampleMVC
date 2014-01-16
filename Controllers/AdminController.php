<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;
use Core\Http\Response\JsonResponse;

class AdminController extends BaseController
{
    public function indexAction()
    {
        $repo = $this->get('db')->getRepository('Survey');
        $surveys = $repo->findAllGroupedByStatus();

        return $this->render('Admin::index', array(
            'surveys' => $surveys
        ), 'admin.html.php');
    }

    public function editAction($id)
    {
        $surveyRepo = $this->get('db')->getRepository('Survey');

        $post = $this->get('request')->post;
        if($this->get('request')->isAjaxRequest() && !empty($post)) {
            //TODO forms
            //TODO validator
            $survey = $post->get('id') ? $surveyRepo->find($post->get('id')) : array();
            $survey['title'] = $post->get('title');

            if(empty($survey['title'])) {
                return new JsonResponse(array('result' => false, 'msg' => 'Название опроса не должно быть пустым'), 400);
            }

            $questions = $post->get('questions');
            if(count($questions) < 1) {
                return new JsonResponse(array('result' => false, 'msg' => 'Нужно ввести хотя бы один вопрос'), 400);
            }

            $hasRequiredQuestion = false;
            $hasInvalidQuestions = false;
            array_map(function($question) use (&$hasRequiredQuestion, &$hasInvalidQuestions) {
                if($question['required'] == 'true') {
                    $hasRequiredQuestion = true;
                }
                if(count($question['answers']) < 2 || empty($question['title'])) {
                    $hasInvalidQuestions = true;
                }
            }, $questions);

            if(!$hasRequiredQuestion || $hasInvalidQuestions) {
                return new JsonResponse(array('result' => false, 'msg' => 'При валидации одного из вопросов возникли ошибки'), 400);
            }

            $surveyRepo->persist($survey);

            $questionRepo = $this->get('db')->getRepository('Question');

            //We need to validate all before attempt to save so making loop the second time
            array_map(function($question) use ($survey, $questionRepo) {
                
            }, $questions);

            return new JsonResponse(array('result' => true, 'redirect' => $this->get('routing')->generate('admin_index')));
        }

        $survey = $surveyRepo->find($id);

        //TODO делать реквест на сервер чтоб получить уникальный идентификатор формы до того как она будет сохранена

        return $this->render('Admin::edit', array(
            'survey' => $survey
        ), 'admin.html.php');
    }
}
