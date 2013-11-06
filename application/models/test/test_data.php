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
    	array_push($this->questions, $question);
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

}

/* End of file Test_Data.php */