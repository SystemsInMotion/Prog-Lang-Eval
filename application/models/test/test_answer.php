<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_answer extends CI_Model {

	private $id;

	private $text;
	
	private $correct;
	
	function __construct() {
		parent::__construct();
        $this->text = "";
        $this->correct = false;
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
		$this->correct = ($correct === true || $correct === "true");
    }
	
	public function isCorrect() {
		return $this->correct === true;
	}

}

/* End of file test_answer.php */