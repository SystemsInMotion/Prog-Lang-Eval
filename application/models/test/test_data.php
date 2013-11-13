<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include "test_level.php";

class Test_data extends CI_Model {
	
	private $id;
	private $type;
	private $name;

	private $intro;
	private $questions;
	private $levels;
	
	private $total_score;
	
	private $questions_answered;
	
	function __construct() {
		parent::__construct();
        $this->intro = "";
        $this->questions = array();
        
        $this->questions_answered = array();
		
		$this->levels = array();
		
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
    
    public function setName($name) {
    	$this->name = $name;	
    }
    
    public function getName() {
    	return $this->name;
    }
    
    public function setIntro($intro) {
    	$this->intro = $intro;
    }
    
    public function getIntro() {
    	return $this->intro;
    }
    
    public function addQuestion(Test_question $question) {
    	$this->questions[$question->getId()] = $question;
    	
    	$level = $this->getLevel($question->getLevel());
    	$level->addQuestion($question);
    }
    
    public function getLevel($number) {
    	if (! array_key_exists($number, $this->levels)) {
    		$level = new Test_level();
    		$this->levels[$number] = $level;
    	}
    	
    	return $this->levels[$number];
    }
    
    public function getLevels() {
    	ksort($this->levels);
    	return $this->levels;
    }
    
    public function getLevelCount() {
    	return count($this->levels);
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
    	$this->questions_answered[$qid] = "declined";
    	
    	$question = $this->getQuestionById($qid);
    	$question->setDeclined(true);
    }

    public function getTotalDeclined() {
    	$answers = array_count_values($this->questions_answered);
    	return $answers["declined"];
    }
    
    public function addAnswered($aid) {
    	$qid = $this->getQIDFromAID($aid);
    	$this->questions_answered[$qid] = "answered";
    	
    	$question = $this->getQuestionById($qid);
    	$question->addGivenAnswer($aid);
    }
    
    public function getAnswered() {
    	return $this->questions_answered;
    }
    
    public function getTotalAnswered() {
    	$answers = array_count_values($this->questions_answered);
    	return $answers["answered"];
    }
    
    public function addScore($score) {
    	$this->total_score += $score;
    }
    
    public function getTotalScore() {
    	return $this->total_score;
    }
    
    public function getScoreDistribution($possible_scores) {
    	$all_levels = array();
    	
    	//Create a prototype array for the scores of an individual level
		$level_scores = array();
		foreach ($possible_scores as $score) {
			$converted = $this->_convertScore($score);
			$level_scores[$converted] = 0;
		}
    	    	
    	foreach ($this->questions as $question) {
    		$level_number = $question->getLevel();
    		
    		//Initialize the level if it hasn't been already
    		if (! array_key_exists($level_number, $all_levels)) {
    			$all_levels[$level_number] = $level_scores;	
    		}
    		
    		$score = $this->_convertScore($question->getScore());
    		$all_levels[$level_number][$score]++;
    	}
    	
    	ksort($all_levels);
    	return $all_levels;
    } 
    
    //We have to convert the fractional scores to be all positive integers to use as index keys
    private function _convertScore($score) {
    	$converted = ($score + 1) * 2;
    	return (string) $converted;	
    }

}

/* End of file Test_Data.php */
