<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candidate extends CI_Model {
	
	private $table = 'candidates';
	
	private $fname;
	
	private $lname;
	
	private $id;
	
	function __construct() {
		parent::__construct();

    }
    
    public function findById($id) {
    	$query = $this->db->get_where($this->table, array('id' => $id));
    	
    	if ($query->num_rows() != 1) {
    		echo ("candidate by id ($id) not found");
    		return false;
    	}
		else {
		   $row = $query->row(); 
		
		   $this->fname = $row->first_name;
		   $this->lname = $row->last_name;
		   $this->id = $row->id;
		   
		   return true;
		}
    }

	public function getName() {
		return $this->fname . ' ' . $this->lname;
	}
	
	public function getId() {
    	return $this->id;
    }

}

/* End of file candidate.php */
