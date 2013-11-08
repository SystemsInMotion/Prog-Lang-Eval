<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require "../models/test/test_data.php";
//require "../models/test/test_question.php";
//require "../models/test/test_answer.php";

class Test_parser {
	
	private static $namespace_prefix = 'ple';
	
	private $CI;
	
	public function __construct() {
		$this->CI =& get_instance();
	}
	
	public function parse(SimpleXMLElement $xml) {

		$ple = $this->_getNamespacedData($xml);
		
		$this->CI->load->model('test/Test_data');
		$test = $this->CI->Test_data;
		
		$test->setIntro($ple->intro);
		$test->setId($ple->attributes()->id);
		$test->setType($ple->attributes()->type);
  		
  		foreach ($ple->questions->question as $question_data) {
  			$question = $this->_parseQuestion($question_data);  
			$test->addQuestion($question);
  		}
		
		return $test;
	}
	
	private function _parseQuestion(SimpleXMLElement $question_data) {
		
		$this->CI->load->model('test/Test_question');
		$question = $this->CI->Test_question;
		
		$question = new Test_question();
		
		$question->setText($this->_innerHTML($question_data->text));

		$question->setId('q' . (string)$question_data->attributes()->id);
		$question->setLevel((string)$question_data->attributes()->level);
		
		foreach ($question_data->answers->answer as $answer_data) {
			$answer = $this->_parseAnswer($answer_data, $question->getId());
			$question->addAnswer($answer);
		}
		
		return $question;
	}
	
	private function _parseAnswer(SimpleXMLElement $answer_data, $question_id) {
				
		$this->CI->load->model('test/Test_answer');
		$answer = $this->CI->Test_answer;
		
		$answer = new Test_answer();
			
		$answer->setId($question_id . '_a' . $answer_data->attributes()->id);
		$correct = (string)$answer_data->attributes()->correct;
		$answer->setCorrect($correct === "true");
  				
  		$answer->setText($this->_innerHTML($answer_data));

		return $answer;
	}
	
	private function _getNamespacedData($xml) {
  		$namespaces = $xml->getNameSpaces(true);
  		$data = $xml->children($namespaces[self::$namespace_prefix]); 
  		
  		return $data;
	}
	
	private function _innerHTML(SimpleXMLElement $el) {
		$xml = $el->asXML();
		
		//At the beginning of the string, after any spaces,
		//Find everything between '<' and '>', 
		//Capturing everything between '<' and '>' or ' ' in [1], 
		//And everything between [1] and '>' in [2]. 
		$has_open_tag = preg_match('/^\s*<([^ >]*)([^>]*)>/', $xml, $matched);
		
		if ($has_open_tag) {
			$tag_name = $matched[1];
			$open_tag = $tag_name . $matched[2];

			//Find '</' $tag_name '>' near the end of the string
			$has_close_tag = preg_match("/<\/($tag_name)>\s*$/", $xml, $matched);
			if ( ! $has_close_tag) {
				die("No close tag found matching open tag:".$open_tag."\n\n<br><br>".$xml);	
			}
			
			$close_tag = $matched[1];
			
			//Find everything between the opening and closing tag and capture in [1]
			$matched = preg_match("/^\s*<$open_tag>(.*)<\/$close_tag>\s*$/", $xml, $match);
			
			return ($matched == 1)? $match[1] : $xml;
				
		}
		else {
			return $xml;
		}
		
	}
}

/* End of file test_parser.php */