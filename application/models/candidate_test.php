<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate_test extends CI_Model {
	
	private $table = 'candidate_tests';
	
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

//    	$this->load->model('Test');
//    	$loaded &= $this->Test->findById($row->test_id);

		return $loaded;
    }
    
    public function getCandidate() {
    	return $this->Candidate;
    }
    
    public function getTest() {
    	return $this->Test;
    }

}

/* End of file candidate.php */