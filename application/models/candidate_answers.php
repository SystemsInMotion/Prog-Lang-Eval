<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate_answers extends CI_Model {
	
	private $table = 'test_answers';
	
	function __construct() {
		parent::__construct();

    }
    
    public function saveAnswers($tid, $answers) {
    	$data = array();    	
//    	d($answers);
    	foreach ($answers as $qid => $given) {
    		if (! is_array($given)) {
    			$given = array($given);
    		} 
    		
    		foreach ($given as $aid) {
    			array_push($data, array(
    				'test_taken_id' => $tid,
    				'question_id' => $qid,
    				'answer_id'=> $aid
    			));
    		}  		
    	}
    	
    	return $this->db->insert_batch($this->table, $data);
    }
}

/* End of file candidate.php */
