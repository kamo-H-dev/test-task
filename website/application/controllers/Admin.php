<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel');
    }

    public function index()
    {
        $questions   = $this->QuestionModel->getQuestions();
        $results     = $this->QuestionModel->getAnsweredQuestions();
        $globRes     = array();
        $answersRes  = array();
        $answer_date = isset($results[0]->answer_date) ? $results[0]->answer_date : '';

        foreach ($results as $result) {
            if ($result->answer_text) {
                $answer_text = $result->answer_text;
            } else {
                $answer_text = '';
                $answerId    = json_decode($result->answers_id);
                $answeres    = $this->AnswerModel->getAnsweresById($answerId, $result->question_id);
                foreach ($answeres as $answer) {
                    $answer_text .= $answer->answer_text . ', ';
                }

                $answer_text = trim($answer_text, ', ');
            }

            if ($answer_date != $result->answer_date) {
                $count = $this->AnswerModel->getCount($result->user_ip)->count;
                if (count($questions) != 0 && $count != 0) {

                    $count = $count / count($questions);
                }

                $globRes[] = array(
                    'userIp'     => $result->user_ip,
                    'answersRes' => $answersRes,
                    'count'      => $count,
                    'answerDate' => $result->answer_date,
                );

                $answer_date = $result->answer_date;
                $answersRes  = array();
            }

            $answersRes[] = array(
                'questionAnswer' => $answer_text,
                'isRight'        => $result->is_right,
                'question_text'  => $result->question_text,

            );

        }

        if (isset($result) && $answersRes) {

            $count = $this->AnswerModel->getCount($result->user_ip)->count;
            if (count($questions) != 0 && $count != 0) {

                $count = $count / count($questions);
            }

            $globRes[] = array(
                'userIp'     => $result->user_ip,
                'answersRes' => $answersRes,
                'count'      => $count,
                'answerDate' => $result->answer_date,
            );
        }

        $this->data['statistic']   = $this->AnswerModel->getAllRightAnswersCount();
        $this->data['totalCount']   = $this->AnswerModel->getTotalCount()->count;
        $this->data['questions']   = $questions;
        $this->data['userAnswers'] = $globRes;
        $this->load->view('admin/default', $this->data);
    }

    public function removeAnswer()
    {
        if ($this->input->is_ajax_request()) {
            $result     = true;
            $userIp     = $this->input->post('user_ip', true);
            $answerDate = $this->input->post('answer_date', true);
            $removeData = array(
                'user_ip'     => $userIp,
                'answer_date' => $answerDate,
            );
            $res        = $this->AnswerModel->removeAnswer($removeData);
            if (!$res) {
                $result = false;
            }
            echo json_encode(array('result' => $result, 'message' => 'Строка успешно была удаленаю'));
            exit;

        } else {
            echo json_encode(array('result' => false, 'message' => '404 error'));
            exit;
        }

    }

}
