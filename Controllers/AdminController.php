<?php

namespace Controllers;

use Core\Controller\Controller as BaseController;
use Core\Http\Response\JsonResponse;

use Repository\SurveyRepository;
use Repository\QuestionRepository;

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
        $questionRepo = $this->get('db')->getRepository('Question');
        $answerRepo = $this->get('db')->getRepository('Answer');

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
                if($question['required'] == QuestionRepository::QUESTION_REQUIRED) {
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



            //We need to validate all before attempt to save so making loop the second time
            array_map(function($question) use ($survey, $questionRepo, $answerRepo) {
                $question['survey'] = $survey['id'];
                $answers = $question['answers'];
                unset($question['answers']);

                $questionRepo->persist($question);
                foreach ($answers as $answer) {
                    $answer['survey'] = $survey['id'];
                    $answer['question'] = $question['id'];

                    $answerRepo->persist($answer);
                }
            }, $questions);

            return new JsonResponse(array('result' => true, 'redirect' => $this->get('routing')->generate('admin_index')));
        }

        $survey = $surveyRepo->find($id);
        $questions = array();
        if($survey) {
            $questions = $questionRepo->findBySurvey($survey['id']);
            if($questions) {
                $questions = array_map(function($question) use ($answerRepo) {
                    $answers = $answerRepo->findByQuestion($question['id']);
                    $question['answers'] = $answers;

                    return $question;
                }, $questions);
            }
        }

        //TODO делать реквест на сервер чтоб получить уникальный идентификатор формы до того как она будет сохранена

        return $this->render('Admin::edit', array(
            'survey' => $survey,
            'questions' => $questions
        ), 'admin.html.php');
    }

    public function deleteAction($id)
    {
        // $id = $this->get('request')->post->get('id');
        if(empty($id)) {
            return new JsonResponse(array('result' => false, 'msg' => 'Не передан идентификатор удаляемого опроса'), 400);
        }

        $surveyRepo = $this->get('db')->getRepository('Survey');
        $surveyRepo->delete($id);

        return new JsonResponse(array('result' => true));
    }

    public function changeStatusAction($id, $newstatus)
    {
        $surveyRepo = $this->get('db')->getRepository('Survey');

        $survey = $surveyRepo->find($id);
        if(!$survey) {
            return new JsonResponse(array('result' => false, 'msg' => 'Опроса с таким идентификатором не существует'), 400);
        }

        switch ($newstatus) {
            case 'active':
                $active = $surveyRepo->findOneByStatus(SurveyRepository::SURVEY_ACTIVE);
                if(!empty($active)) {
                    return new JsonResponse(array('result' => false, 'msg' => 'Активный опрос уже существует'), 400);
                }

                $survey['status'] = SurveyRepository::SURVEY_ACTIVE;
                $surveyRepo->persist($survey);
                break;

            case 'closed':
                $survey['status'] = SurveyRepository::SURVEY_CLOSED;
                $surveyRepo->persist($survey);
                break;
            
            default:
                return new JsonResponse(array('result' => false, 'msg' => 'Неприменимый статус'), 400);
                break;
        }

        return new JsonResponse(array('result' => true));
    }
}
