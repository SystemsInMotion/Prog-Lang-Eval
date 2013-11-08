<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_answer extends CI_Model {

	private $id;

	private $text;
	
	private $correct;
	private $given;
	
	private $question;
	
	function __construct() {
		parent::__construct();
        $this->text = "";
        $this->correct = false;
        
        $this->given = false;
    }
    
    public function setId($id) {
    	$this->id = $id;
    }
    
    public function getId() {
    	return $this->id;
    }
    
    public function setText($text) {
    	$this->text = $text;
    }
    
    public function getText() {
    	return $this->text;
    }
    
    public function setCorrect($correct) {
		$this->correct = $correct === true;
    }
	
	public function isCorrect() {
		return $this->correct;
	}
	
	public function setGiven() {
		$this->given = true;
    }
	
	public function wasGiven() {
		return $this->given;
	}
	
	public function setQuestion(Test_question $question) {
		$this->question = $question;
	}
	
	public function getQuestion() {
		return $this->question;
	}

}

/* End of file test_answer.php */
