<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends CI_Model {
	
	private $table = 'candidates';
	
	private $fname;
	
	private $lname;
	
	function __construct() {
		parent::__construct();

    }
    
    public function findById($id) {
    	$query = $this->db->get_where($this->table, array('id' => $id));
    	
    	if ($query->num_rows() != 1) {
    		return false;
    	}
		else {
		   $row = $query->row(); 
		
		   $this->fname = $row->first_name;
		   $this->lname = $row->last_name;
		   
		   return true;
		}
    }

	public function getName() {
		return $this->fname . ' ' . $this->lname;
	}

}

/* End of file candidate.php */