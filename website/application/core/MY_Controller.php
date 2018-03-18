<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author  Miasnik Davtyan
 *
 * @property session $session
 * @property QuestionModel $QuestionModel
 * @property AnswerModel $AnswerModel
 */

class MY_Controller extends CI_Controller
{
    /**
     * Information about the user identity
     *
     * @var array
     */
    protected $_identity;

    /**
     * About main layout
     *
     */
    public $data = array();

    /**
     * Information about the variables
     *
     * @var object
     */
    protected $_db_details;



    /**
     * Constructor function
     */
    public function __construct()
    {
        parent::__construct();
    }



}









