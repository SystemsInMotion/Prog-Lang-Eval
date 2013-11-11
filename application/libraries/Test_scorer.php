<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_scorer {
	
	const INCORRECT_PENALTY = -0.5;
	const ALL_CORRECT_SCORE = 1;
	const PARTIAL_CORRECT_SCORE = 0.5;
	
	private static function _calculateScore($correct, $incorrect, $expected) {
		if ($incorrect > 0) {
			return self::INCORRECT_PENALTY;
		}
		else if ($correct === $expected){
			return self::ALL_CORRECT_SCORE;
		}
		else if ($correct > 0){
			return self::PARTIAL_CORRECT_SCORE;
		}
	}
	
	public function score(Test_data $test, $answers) {
	
		foreach($answers as $id => $given) {
			$qid = $test->getQIDFromAID($id);
			
			if ($given === "decline") {
				$test->addDeclined($qid);
			}
			else {
				$test->addAnswered($given);
			}
		}
		
		$this->_scoreAnswers($test);		
	}
	
	private function _scoreAnswers(Test_data &$test) {
		foreach ($test->getLevels() as $level) {
			foreach ($level->getQuestions() as $question) {
				$score = self::_calculateScore(
					$question->getCorrect(),
					$question->getIncorrect(),
					$question->getExpectedCorrect()
				);
				
				$question->setScore($score);
				$level->addScore($score);
				$test->addScore($score);
			}
		}
	}
}

/* End of file test_score.php */
