<?php

class AnswerModel extends CI_Model
{
    protected $table;

    function __construct()
    {
        $this->load->database();
        parent::__construct();
        $this->table = 'answers';
    }

    public function getAnsweresByQid($questionId)
    {

        $query = $this->db->get_where($this->table, array('question_id' => $questionId));

        return $query->result();
    }

    public function getAnsweresById($id, $questionId)
    {
        $this->db->where('question_id', $questionId);
        $this->db->where_in('id', $id);
        $query = $this->db->get($this->table);

        return $query->result();
    }

    public function insertAnswers($data)
    {
        $this->db->insert('user_answers', $data);
    }

    public function getCount($userIp)
    {
        $this->db->select('COUNT(*) AS count');
        $this->db->where('user_ip', $userIp);
        $query = $this->db->get('user_answers');
        return $query->row();
    }
    public function getTotalCount(){
        $this->db->select('COUNT(*) AS count');
        $this->db->where('is_right', 1);
        $query = $this->db->get('user_answers');
        return $query->row();
    }

    public function getAllRightAnswersCount(){
        $this->db->select('
        COUNT(*) AS count, 
        user_answers.question_id as question_id, 
        questions.question_text as question_text');
        $this->db->where('is_right', 1);
        $this->db->join('questions', 'questions.id = user_answers.question_id', 'left');
        $this->db->group_by('user_answers.question_id');
        $query = $this->db->get('user_answers');
        return $query->result();
    }

    public function removeAnswer($where)
    {
        return $this->db->delete('user_answers', $where);
    }
}