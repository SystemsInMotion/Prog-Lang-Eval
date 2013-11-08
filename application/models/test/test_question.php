<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_question extends CI_Model {

	private $id;
	private $level;

	private $text;
	
	private $answers;
	
	private $expected_correct;
	private $correct;
	private $incorrect;
	
	private $declined;
	
	private $score;
	
	function __construct() {
		parent::__construct();
				
        $this->text = "";
        $this->answers = array();
        
        $this->expected_correct = 0;
        $this->correct = 0;
        $this->incorrect = 0;
        
        $this->declined = false;
    }
    
    public function setId($id) {
    	$this->id = $id;
    }
    
    public function getId() {
    	return $this->id;
    }
    
    public function setLevel($level) {
    	$this->level = $level;
    }
    
    public function getLevel() {
    	return $this->level;
    }
    
    public function setText($text) {
    	$this->text = $text;
    }
    
    public function getText() {
    	return $this->text;
    }
    
    public function addAnswer(Test_answer $answer) {
    	$this->answers[$answer->getId()] = $answer;
    	$answer->setQuestion($this);
    	
    	if ($answer->isCorrect()) {
    		$this->expected_correct++;
    	}
    }
    
    public function getAnswers($shuffle) {
    	if ($shuffle) {
    		$shuffled = $this->answers;
    		shuffle($shuffled);
    		return $shuffled;
    	}
    	else {
    		return $this->answers;
    	}
    }
    
    public function getAnswerById($id) {
    	if (array_key_exists($id, $this->answers)) {
    		return $this->answers[$id];
    	}
    	else {
    		log_message('error', 'Given aID not found: ('.$this->id.')'.$id);
    		return null;
    	}
    }
    
    public function hasMultipleAnswers() {
    	return $this->expected_correct > 1;
    }
    
    public function getExpectedCorrect() {
    	return $this->expected_correct;
    }
    
    public function getCorrect() {
    	return $this->correct;
    }
    
    public function getIncorrect() {
    	return $this->incorrect;
    }
    
    public function setDeclined($declined) {
    	$this->declined = $declined === true;
    }
    
    public function isDeclined() {
    	return $this->declined;
    }
    
    public function addGivenAnswer($aid) {
    	$answer = $this->getAnswerById($aid);
    	$answer->setGiven();

    	if ($answer->isCorrect()) {
    		$this->correct++;
    	}
    	else {
    		$this->incorrect++;
    	}
    }
	
	public function setScore($score) {
		$this->score = $score;
	}
	
	public function getScore() {
		return $this->score;
	}
}

/* End of file Test_Question.php */
