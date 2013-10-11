<?php

class issue {
	
	private $db;
	
	// attributi
	public $id_issue = null;
	
	private $name = null;
	private $description = null;
	private $rank = null;
	
	public $note;
	public $date;
	
	public function __construct($db) {
		$this->db = $db;		
	}
	
	public function load($id_issue) {
		$sql = sprintf("SELECT * FROM issues WHERE id_issue = %d LIMIT 1", (int)$id_issue);
		$res = $this->db->query($sql);
		if (!$res || $res->num_rows == 0) { return false; exit(); }
		
		$data = $this->db->result2array($res);
		
		$this->id_issue = $id_issue;
		$this->name = $data['name'];
		$this->description = $data['description'];
		$this->rank = $data['rank'];
		
		return true;
	}
	
	public function getName($id_issue = null) {
		if (is_null($id_issue)) { $id_issue = $this->id_issue; }
		if (is_null($id_issue)) { return false; exit(); }
		
		return $this->name;

	}

	public function getDescription($id_issue = null) {
		if (is_null($id_issue)) { $id_issue = $this->id_issue; }
		if (is_null($id_issue)) { return false; exit(); }
		
		return $this->description;

	}
	
}