<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_question extends CI_Model {

	private $id;
	private $level;

	private $text;
	
	private $answers;
	
	private $number_of_correct;
	
	function __construct() {
		parent::__construct();
				
        $this->text = "";
        $this->answers = array();
        
        $this->number_of_correct = 0;
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
    	array_push($this->answers, $answer);
    	
    	if ($answer->isCorrect()) {
    		$this->number_of_correct++;
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
    
    public function hasMultipleAnswers() {
    	return $this->number_of_correct > 1;
    }
	
}

/* End of file Test_Question.php */