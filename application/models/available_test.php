<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Available_test extends CI_Model {
	
	private $table = 'available_tests';
	
	private $display_name;
	
	private $filename;	
	
	private $id;
	
	function __construct() {
		parent::__construct();

    }
    
    public function findById($id) {
    	$query = $this->db->get_where($this->table, array('id' => $id));
    	
    	if ($query->num_rows() != 1) {
    		echo ("available test by id ($id) not found");
    		return false;
    	}
		else {
			$row = $query->row(); 
			return $this->_loadTest($row);
		}
    }
    
    private function _loadTest($row) {
    	$this->display_name = $row->display_name;
    	$this->filename = $row->filename;
    	$this->id = $row->id;
    	return true;
    }
    
    public function getDisplayName() {
    	return $this->display_name;
    }
    
    public function getFilename() {
    	return $this->filename;
    }

	public function getId() {
    	return $this->id;
    }
}

/* End of file candidate.php */