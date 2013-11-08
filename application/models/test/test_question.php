<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_question extends CI_Model {

	private $id;
	private $level;

	private $text;
	
	private $answers;
	
	private $expected;
	
	function __construct() {
		parent::__construct();
				
        $this->text = "";
        $this->answers = array();
        
        $this->expected = 0;
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
    		$this->expected++;
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
    	return $this->number_of_correct > 1;
    }
    
    public function getExpected() {
    	return $this->expected;
    }
	
}

/* End of file Test_Question.php */
