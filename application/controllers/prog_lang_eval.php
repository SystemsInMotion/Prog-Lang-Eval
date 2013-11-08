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
		
		$data['test'] = $test;
		
		$this->load->view('test_results_view', $data);

	}

}

/* End of file prog_lang_eval.php */
