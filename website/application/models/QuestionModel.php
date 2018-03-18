<?php

class QuestionModel extends CI_Model
{
    protected $table;

    function __construct()
    {
        $this->load->database();
        parent::__construct();
        $this->table = 'questions';
    }

    public function getQuestions() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getQuestionById($id) {
        $this->db->select($this->table.'.*, answers.id as answer_id, answers.answer_text as answer_text ');
        $this->db->join('answers', 'answers.question_id = '.$this->table.'.id','left');
        $query = $this->db->get_where($this->table, array($this->table . '.id' => $id, 'answers.is_right' => 1) );
        return $query->result();
    }



    public function getAnsweredQuestions() {
        $this->db->select('
        user_answers.*,
        ' . $this->table . '.id as question_id,
        '. $this->table . '.question_text as question_text');
        $this->db->join($this->table, 'user_answers.question_id = '.$this->table.'.id','left');
        $this->db->order_by('user_answers.user_ip',  "asc");
        $this->db->order_by('user_answers.answer_date',  "asc");
        $this->db->order_by('user_answers.question_id',  "asc");
        $query = $this->db->get('user_answers');
        return $query->result();
    }

    public function getRezults() {
        $query = $this->db->get('user_answers');
        return $query->result();
    }


}