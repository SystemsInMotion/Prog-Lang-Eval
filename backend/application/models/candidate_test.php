<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate_test extends CI_Model {
	
	private $table = 'candidate_tests';
	
	private $id;
	
	private $completed;
	
	function __construct() {
		parent::__construct();

    }
    
    public function findByCode($code) {
    	$query = $this->db->get_where($this->table, array('code' => $code));
    	
    	if ($query->num_rows() != 1) {
    		echo ("test by code ($code) not found");
    		return false;
    	}
		else {
			$row = $query->row(); 
			return $this->_loadTest($row);
		}
    }
    
    private function _loadTest($row) {
    	$this->load->model('Candidate');
    	$loaded = $this->Candidate->findById($row->candidate_id);

    	$this->load->model('Available_test');
    	$loaded &= $this->Available_test->findById($row->test_id);
    	
    	$this->id = $row->id;
    	$this->completed = $row->completed;

		return $loaded;
    }
    
    public function saveAnswers($answers) {
    	$this->load->model('Candidate_answers');
    	
    	$this->Candidate_answers->saveAnswers($this->id, $answers);
    }
    
    public function getCandidate() {
    	return $this->Candidate;
    }
    
    public function getTest() {
    	return $this->Available_test;
    }
    
    public function getId() {
    	return $this->id;
    }
    
    public function recordStart() {
    	$this->db->query('UPDATE '.$this->table.' SET `started`=NOW() WHERE `id`='.$this->id.';');
    }
    
    public function recordComplete() {
    	$this->db->query('UPDATE '.$this->table.' SET `completed`=NOW() WHERE `id`='.$this->id.';');
    }
    
    public function isCompleted() {
    	return $this->completed != null;	
    }
    
    public function recordScore($score) {
    	$this->db->update($this->table, array('final_score' => $score), array('id' => $this->id));
    }

}

/* End of file candidate.php */
