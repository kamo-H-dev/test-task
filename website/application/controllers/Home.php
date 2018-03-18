<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    private $questions;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('QuestionModel');
        $this->load->model('AnswerModel');
        $this->questions = $this->QuestionModel->getQuestions();
    }

    public function index()
    {
        if (!empty($this->questions)) {

            foreach ($this->questions as $key => $question) {
                $question->answers = $this->AnswerModel->getAnsweresByQid($question->id);
            }

        }

        $this->data['questions'] = $this->questions;
        $this->load->view('default', $this->data);
    }

    public function saveResult()
    {

        if ($this->input->is_ajax_request()) {
            $questAnswers = $this->input->post('answer', true);
            $userIp       = $this->getClientIp();

            if (!$this->input->cookie('inserted_data', true)) {

                if (count($questAnswers) == count($this->questions)) {
                    $date = date('Y-m-d H:i:s');

                    foreach ($questAnswers as $qId => $questAnswer) {
                        $insertData = array();

                        $questions                 = $this->QuestionModel->getQuestionById($qId);
                        $insertData['question_id'] = $qId;
                        $insertData['is_right']    = 0;
                        $insertData['user_ip']     = $userIp;
                        $insertData['answer_date'] = $date;
                        $right_answer              = null;

                        if ($questions[0]->answer_type == 'checkbox') {

                            foreach ($questions as $question) {
                                $right_answer[] = $question->answer_id;
                            }
                            $questAnswerArr = array_keys($questAnswer);
                            sort($right_answer);
                            sort($questAnswerArr);

                            if ($right_answer == $questAnswerArr) {
                                $insertData['is_right'] = 1;
                            }

                            $insertData['answers_id'] = json_encode($questAnswerArr);
                        } elseif ($questions[0]->answer_type == 'text') {

                            if ($questAnswer == $questions[0]->answer_text) {
                                $insertData['is_right'] = 1;
                            }

                            $insertData['answer_text'] = $questAnswer;

                        } else {
                            if ($questAnswer == $questions[0]->answer_id) {
                                $insertData['is_right'] = 1;
                            }
                            $insertData['answers_id'] = $questAnswer;
                        }

                        $this->AnswerModel->insertAnswers($insertData);
                    }
                    setcookie('inserted_data', 2);
                    echo json_encode(array('result' => true, 'data' => $insertData));
                    exit;
                } else {
                    echo json_encode(array('result' => false, 'message' => 'Пожалуйста ответьте на все вопросы'));
                    exit;
                }
            }
            echo json_encode(array('result' => false, 'message' => 'Ваш ответ уже принят'));
            exit;
        } else {
            echo json_encode(array('result' => false, 'message' => '404 error'));
            exit;
        }

    }

    function getClientIp()
    {
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                if (getenv('HTTP_X_FORWARDED')) {
                    $ipaddress = getenv('HTTP_X_FORWARDED');
                } else {
                    if (getenv('HTTP_FORWARDED_FOR')) {
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    } else {
                        if (getenv('HTTP_FORWARDED')) {
                            $ipaddress = getenv('HTTP_FORWARDED');
                        } else {
                            if (getenv('REMOTE_ADDR')) {
                                $ipaddress = getenv('REMOTE_ADDR');
                            } else {
                                $ipaddress = 'UNKNOWN';
                            }
                        }
                    }
                }
            }
        }
        return $ipaddress;
    }

}
