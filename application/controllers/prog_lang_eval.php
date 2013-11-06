<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prog_lang_eval extends CI_Controller {
	
	private $review_mode = false;

	public function index() {
		
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


}

/* End of file prog_lang_eval.php */
