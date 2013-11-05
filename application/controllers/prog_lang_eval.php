<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prog_lang_eval extends CI_Controller {
	
	private $review_mode = true;

	public function index()
	{
		
		$xml = simplexml_load_file('assets/xml/tests/java_1.0.xml');
		
		//Use that namespace
  		$namespaces = $xml->getNameSpaces(true);
  		$ple = $xml->children($namespaces['ple']); 
  		
  		$question_set = array();
  		foreach ($ple->questions->question as $question_data) {
  			$question['text'] = $this->_innerHTML($question_data->text);
	
			$question['number'] = $question_data->attributes()->id;
  			$question['id'] = 'q' . $question['number'];
  			$question['level'] = $question_data->attributes()->level;

  			$answers = array();
  			$correct = 0;
  			
  			foreach ($question_data->answers->answer as $answer_data) {
  				
  				$answer['correct'] = $answer_data->attributes()->correct;
  				if ($answer['correct']) {
  					$correct++;
  
  				}
  				
  				$answer['text'] = $this->_innerHTML($answer_data);
  				$answer['id'] = $question['id'] . '.a' . $answer_data->attributes()->id;
  				
  				array_push($answers, $answer);
  			}
  			
  			$question['multiplicity'] = $correct;

			if ( ! $this->review_mode) {
				shuffle($answers);
			}
			
  			$question['answers'] = $answers;
  			
  			array_push($question_set, $question);
  		}
		
		$data['test_intro'] = $ple->intro;
		
		if ( ! $this->review_mode) {
			shuffle($question_set);
		}
		
		$data['questions'] = $question_set;
		$data['review'] = $this->review_mode;
		
		$this->load->view('prog_lang_eval_view', $data);
	}
	
	private function _innerHTML(SimpleXMLElement $el) {
		$xml = $el->asXML();
		
		//find whitespaces, then something between <>, then anything followed by </ (the thing before) >
		//Captures the middle group (between the tags) and removes everything else.
		$matched = preg_match("/^\s*<([^>]*)>(.*)(<\/\\1>)\s*$/", $xml, $match);
		
//		die(print_r($match, true));
		
		return ($matched == 1)? $match[2] : $xml;
	}

}

/* End of file prog_lang_eval.php */
