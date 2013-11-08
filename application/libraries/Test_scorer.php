<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_scorer {
	
	private $CI;
	
	const INCORRECT_PENALTY = -0.5;
	const ALL_CORRECT_SCORE = 1;
	const PARTIAL_CORRECT_SCORE = 0.5;

	
	public function __construct() {
		
		$this->questions_answered = array();
		$this->questions_declined = array();
		
		$this->answers_by_level = array();
		
		$this->CI =& get_instance();
	}
	
	private static function _calculateScore($correct, $incorrect, $expected) {
		if ($incorrect > 0) {
			return self::INCORRECT_PENALTY;
		}
		else if ($correct === $expected){
			return self::ALL_CORRECT_SCORE;
		}
		else {
			return self::PARTIAL_CORRECT_SCORE;
		}
	}
	
	public function score(Test_data $test, $answers) {
	
		foreach($answers as $id => $given) {
			$qid = $test->getQIDFromAID($id);
			
			if ($given === "decline") {
				array_push($this->questions_declined, $qid);
			}
			else {
				$answer = $test->getAnswerById($given);
			
				if ($answer == null) {
					show_error('Given answer not found: ('.$id.')'.$given);
				}
				else {
					array_push($this->questions_answered, $qid);
					$this->_recordAnswer($answer);
				}
			}
		}
		
		$this->_scoreAnswers();
		
		return $this;
		
	}
	
	private function _scoreAnswers() {
		foreach ($this->answers_by_level as $level => &$answers) {
			foreach ($answers as $qid => &$answer_score) {
				$score = self::_calculateScore(
					$answer_score['correct'],
					$answer_score['incorrect'],
					$answer_score['expected']
				);
				
				
				$answer_score['score'] = $score;
				$this->final_score += $score;
			}
		}
	}
	
	private function _recordAnswer(Test_answer $answer) {

		$question = $answer->getQuestion();
		
		$score =& $this->_getQuestionScore($question);		
		
		if ($answer->isCorrect()) {
			$score['correct'] += 1;
		}
		else {
			$score['incorrect'] += 1;
		}
	}
	
	private function &_getQuestionScore(Test_question $question) {
		$level =& $this->_getLevelScore($question->getLevel());
		
		$qid = $question->getId();
		
		if (! array_key_exists($qid, $level)) {
			$level[$qid] = array(
				'correct' => 0,
				'incorrect' => 0,
				'expected' => $question->getNumberOfCorrect()
			);
		}
		
		return $level[$qid];
	}
	


}

/* End of file test_score.php */
