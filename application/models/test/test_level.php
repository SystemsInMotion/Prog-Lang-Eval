<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_level extends CI_Model {
	
	private $questions;
	
	private $score;
			
	function __construct() {
		parent::__construct();
	
		$this->questions = array();
    }

	public function addQuestion(Test_question $question) {
		$this->questions[$question->getId()] = $question;
	}
	
	public function getQuestions() {
		ksort($this->questions);
		return $this->questions;
	}
	
	public function getTotalQuestions() {
		return count($this->questions);
	}
	
	public function getScoreDistribution() {
		$scores = array();
		
		foreach($this->questions as $question) {
			$score = (string)$question->getScore();
			if (!array_key_exists($score, $scores)) {
				$scores[$score] = 0;
			}
			$scores[$score]++;
		}
		
		krsort($scores);
		return $scores;
	}
	
	public function addScore($score) {
		$this->score += $score;
	}
	
	public function getScore() {
		return $this->score;
	}

}

/* End of file test_level.php */
