<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_data extends CI_Model {
	
	private $id;
	
	private $type;

	private $intro;
	private $questions;
	private $questions_by_level;
	
	private $total_score;
	
	private $questions_answered;
	
	function __construct() {
		parent::__construct();
        $this->intro = "";
        $this->questions = array();
        
        $this->questions_answered = array();
		
		$this->questions_by_level = array();
		
		$this->total_score = 0;
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
    	
    	$level =& $this->getLevel($question->getLevel());
    	$level[$question->getId()] = $question;
    }
    
    public function &getLevel($level) {
    	if (! array_key_exists($level, $this->questions_by_level)) {
    		$this->questions_by_level[$level] = array();
    	}
    	
    	return $this->questions_by_level[$level];
    }
    
    public function getQuestions($shuffle = false) {
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
    
    public function getTotalQuestions() {
    	return count($this->questions);
    }
    
    public static function getQIDFromAID($aid) {
		$ids = explode("_", $aid);
		return $ids[0];
    }
    
    public function addDeclined($qid) {
    	$this->questions_answered[$qid] = false;
    	
    	$question = $this->getQuestionById($qid);
    	$question->setDeclined(true);
    }
    
    public function getDeclined() {
    	$answers = array_count_values($this->questions_answered);
    	return $answers[false];
    }
    
    public function getTotalDeclined() {
    	$answers = array_count_values($this->questions_answered);
    	return $answers[true];
    }
    
    public function addAnswered($aid) {
    	$qid = $this->getQIDFromAID($aid);
    	$this->questions_answered[$qid] = true;
    	
    	$question = $this->getQuestionById($qid);
    	$question->addGivenAnswer($aid);
    }
    
    public function getAnswered() {
    	return $this->questions_answered;
    }
    
    public function getTotalAnswered() {
    	return count($this->questions_answered);
    }
    
    public function addScore($score) {
    	$this->total_score += $score;
    }
    
    public function getTotalScore() {
    	return $this->total_score;
    }

}

/* End of file Test_Data.php */
