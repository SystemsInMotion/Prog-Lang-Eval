<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prog_lang_eval extends CI_Controller {

	public function index()
	{
		
		$xml = simplexml_load_file('assets/xml/tests/java_1.0.xml');
		
		//Use that namespace
  		$namespaces = $xml->getNameSpaces(true);
  		$ple = $xml->children($namespaces['ple']); 
		
		$data['test'] = $ple;
		
		$this->load->view('prog_lang_eval', $data);
	}

}

/* End of file prog_lang_eval.php */
