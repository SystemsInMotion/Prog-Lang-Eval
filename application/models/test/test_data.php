<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_data extends CI_Model {
	
	private $id;
	
	private $type;

	private $intro;
	private $questions;
	
	function __construct() {
		parent::__construct();
        $this->intro = "";
        $this->questions = array();
    }
    
    public function setId($id) {
    	$this->id = $id;
    }
    
    public function getId() {
    	return $this->id;
    }
    
   	public function setType($type) {
    	$this->type = $type;
    }
    
    public function getType() {
    	return $this->type;
    }
    
    public function setIntro($intro) {
    	$this->intro = $intro;
    }
    
    public function getIntro() {
    	return $this->intro;
    }
    
    public function addQuestion(Test_question $question) {
    	$this->questions[$question->getId()] = $question;
    }
    
    public function getQuestions($shuffle) {
    	if ($shuffle) {
    		$shuffled = $this->questions;
    		shuffle($shuffled);
    		return $shuffled;
    	}
    	else {
    		return $this->questions;
    	}
    }
    
    public function getQuestionById($id) {
    	if (array_key_exists($id, $this->questions)) {
    		return $this->questions[$id];
    	}
    	else {
    		log_message('error', 'Given qID not found: '.$id);
    		show_error('Given qID not found: '.$id);
    		return null;
    	}
    }
    
    public function getAnswerById($id) {
    	$qid = $this->getQIDFromAID($id);
    	
    	$question = $this->getQuestionById($qid);
    	$answer = $question->getAnswerById($id);
    	
    	return $answer;
    }
    
    public function totalQuestions() {
    	return count($this->questions);
    }
    
    public static function getQIDFromAID($aid) {
		$ids = explode("_", $aid);
		return $ids[0];
    }

}

/* End of file Test_Data.php */
