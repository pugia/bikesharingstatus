<?php

class City {
	
	private $db;
	public $issues;
	
	public function __construct($db) {
		$this->db = $db;
	}
		
	public function loadIssues($id_city) {
		
		$sql = sprintf("SELECT id_issue FROM city_issues WHERE id_city = %d", (int)$id_city);
		$data = $this->db->result2array($this->db->query($sql));
		if (!empty($data)) {
			foreach ($data as $i) {	
				$issue = new issue($this->db);
				if ($issue->load($i['id_issue'])) $this->issues[] = $issue; 
			}
		}
		
	}
	
	public function addBike($id_city, $serial) {
		
		$serial = trim(strtolower($serial));
		
		$sql = sprintf("INSERT IGNORE 
										INTO city_bikes 
										(id_city, serial) 
										VALUES (%d, '%s')",
										$id_city,
										$this->db->res($serial));
		$res = $this->db->query($sql);
		if (!$res) { return false; exit(); }
		else return $this->db->insert_id();
	}
	
	public function getBikeId($id_city, $serial) {
		$serial = trim(strtolower($serial));

		$sql = sprintf("SELECT id_bike
										FROM city_bikes
										WHERE id_city = %d
											AND serial = '%s'
										LIMIT 1",
										$id_city,
										$this->db->res($serial));
		$res = $this->db->query($sql);
		if ($res && $res->num_rows == 0) { return false; exit(); } 
		
		$data = $res->fetch_assoc();
		return $data['id_bike'];

	}
	
	public function addBikeIssue($id_bike, $id_issue, $note) {
		
		$sql = sprintf("INSERT INTO city_bikes_issues
										(id_bike, id_issue, note)
										VALUES (%d, %d, '%s')",
										$id_bike, $id_issue, $this->db->res($note));
		$res = $this->db->query($sql);
		
		return (bool)($res && $this->db->affected_rows() == 1);
		
	}
	
	public function setBikeStatus($id_bike, $status) {
		
		$sql = sprintf("UPDATE city_bikes 
										SET status = %d
										WHERE id_bike = %d
										LIMIT 1",
										(int)$status, $id_bike);
		$res = $this->db->query($sql);
		return (bool)$res;
		
	}
	
	public function getBikeIssues($id_bike) {
		$sql = sprintf("SELECT id_issue, name, date, note
										FROM city_bikes_issues
											JOIN issues USING (id_issue)
										WHERE id_bike = %d
										ORDER BY date DESC",
										$id_bike);
		$res = $this->db->query($sql);
		if ($res && $res->num_rows == 0) { return false; exit(); } 
		
		$out = array();
		while ($i = $res->fetch_assoc()) {
			$data = date('Ymd', strtotime($i['date']));
			$out[$data][] = $i;
		}
		$output = array();
		foreach ($out as $data => $issues) {
			$output[] = array('data' => $data, 'problems' => $issues);
		}

		return $output;
	}
	
	public function getBikeStatus($id_bike) {
		$sql = sprintf("SELECT status
										FROM city_bikes
										WHERE id_bike = %d
										LIMIT 1",
										$id_bike);
		$res = $this->db->query($sql);
		if ($res && $res->num_rows == 0) { return false; exit(); } 
		
		$data = $res->fetch_assoc();
		return $data['status'];
	}
	
}