<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prog_lang_eval extends CI_Controller {
	
	private $review_mode = true;
	
	public function welcome() {
		$this->load->library('Test_parser');
		
		$xml = simplexml_load_file('assets/xml/tests/java_1.0.xml');
		
		$test = $this->test_parser->parse($xml);
		
		
		$data['intro'] = $test->getIntro();
		
		$shuffle = ( ! $this->review_mode);
		$data['shuffle'] = $shuffle;
		
		$data['questions'] = $test->getQuestions($shuffle);
		
		$data['review'] = $this->review_mode;
		
		
		$this->load->view('prog_lang_eval_view', $data);
	}

	public function index() {

	}

	public function submit() {
		
		$this->load->library('Test_parser');
		
		$xml = simplexml_load_file('assets/xml/tests/java_1.0.xml');
		
		$test = $this->test_parser->parse($xml);
		
		$answers = $this->input->post();
		
		$this->load->library('Test_scorer');
		
		$this->test_scorer->score($test, $answers);
		
		$distribution = $test->getScoreDistribution(Test_scorer::getAllScores());
		$data['graph_data'] = $this->_encodeForBarGraph($distribution);
		$data['test'] = $test;
		
		$this->load->view('test_results_view', $data);

	}
	
	private function _encodeForBarGraph($levels) {
    	$json = "new Array(\n";
    	
  		ksort($levels);
    	
    	$last_level = end(array_keys($levels));
    	foreach ($levels as $level => $scores) {
    		$json .= "[[";
    		
    		$last_score = end(array_keys($scores));
    		foreach ($scores as $score => $count) {
    			$json .= $count;
    			
	    		if ($score !== $last_score) {
	    			$json .= ",";
			    }
    		}
    		
    		$json .= "], 'Level $level']";
    		if ($level !== $last_level) {
    			$json .= ",";
		    }
		    $json .= "\n";
    	}
    	$json .= ")";
    	
    	return $json;	
    }

}

/* End of file prog_lang_eval.php */
