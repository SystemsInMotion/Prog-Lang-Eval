<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prog_lang_eval extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	
		$this->load->database();
		$this->load->library('session');	
	}
	
	private function _prepare_test(Candidate_test $ctest, $review_mode) {
		$file = $ctest->getTest()->getFilename();
		
		$shuffle = ! $review_mode;
		
		$test = $this->_parseTest($file);
		
		$data['candidate'] = $ctest->getCandidate()->getName();
		
		$data['test_name'] = $test->getName();
		$data['version'] = $test->getId();
		$data['intro'] = $test->getIntro();
		$data['questions'] = $test->getQuestions($shuffle);
		
		$data['shuffle'] = $shuffle;
		$data['review'] = $review_mode;		
		
		return $data;
	}
	
	public function welcome() {
	
		$code = $this->input->post('code');
		
		$this->load->model('Candidate_test');
		
		$found = $this->Candidate_test->findByCode($code);
		
		if (! $found || $this->Candidate_test->isCompleted()) {
			$data['error'] = true;
			$this->load->view('start_view', $data);
		}
		else {
			$this->session->set_userdata(array('code' => $code));
			
			$data = $this->_prepare_test($this->Candidate_test, true);
			
			$this->Candidate_test->recordStart();

			$this->load->view('prog_lang_eval_view', $data);
		}
	}

	public function index() {
		
		$data['error'] = false;
		$this->load->view('start_view', $data);
	}

	public function submit() {
		$code = $this->session->userdata('code');
		$answers = $this->input->post();
		
		$this->load->model('Candidate_test');
		$found = $this->Candidate_test->findByCode($code);
		
		if ($found) {
			$saved = $this->Candidate_test->saveAnswers($answers);
		}
		
		if ( ! ($found && $saved)) {
			//Alert the user and dump the answer data to the page to be recovered by the proctor
		}
		
		$this->Candidate_test->recordComplete();
		
		$testFileName = $this->Candidate_test->getTest()->getFilename();
		$test = $this->_parseTest($testFileName);
		
		$this->load->library('Test_scorer');
		
		$this->test_scorer->score($test, $answers);
		
		$this->Candidate_test->recordScore($test->getTotalScore());
		
		$data['candidate'] = $this->Candidate_test->getCandidate()->getName();
		$data['error'] = false;
		
		$this->load->view('test_complete_view', $data);
	}
	
	public function review() {
		$distribution = $test->getScoreDistribution(Test_scorer::getAllScores());
		$data['graph_data'] = $this->_encodeForBarGraph($distribution);
		$data['test'] = $test;
		
		$this->load->view('test_results_view', $data);
	}
	
	private function _parseTest($testFileName) {
		$this->load->library('Test_parser');
		
		$xml = simplexml_load_file('assets/xml/tests/'.$testFileName);
		
		$test = $this->test_parser->parse($xml);
		
		return $test;
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
