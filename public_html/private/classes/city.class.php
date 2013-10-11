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
			$data = date('Y-m-d G:i:00', strtotime($i['date']));
			$out[$data][] = $i;
		}
		$output = array();
		foreach ($out as $data => $issues) {
			$output[] = array('data' => $data, 'data_readable' => $this->contextualTime(strtotime($data)), 'problems' => $issues);
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
	
	private function contextualTime($small_ts, $large_ts=false) {
	  if(!$large_ts) $large_ts = time();
	  $n = $large_ts - $small_ts;
/*
	  if($n <= 1) return _('adesso'); // meno di un secondo fa
	  if($n < (60)) return $n . _('secondi').' '._('fa');
*/
	  if($n < (60*60)) { $minutes = round($n/60); return _('circa'). ' ' . $minutes . ' ' . ($minutes > 1 ? _('minuti') : _('minuto')) . ' '. _('fa'); }
	  if($n < (60*60*16)) { $hours = round($n/(60*60)); return _('circa'). ' ' . $hours . ' ' . ($hours > 1 ? _('ore') : _('ora')) . ' '. _('fa'); }
	  if($n < (time() - strtotime('yesterday'))) return 'ieri';
	  if($n < (60*60*24)) { $hours = round($n/(60*60)); return _('circa'). ' ' . $hours . ' ' . ($hours > 1 ? _('ore') : _('ora')) . ' '. _('fa'); }
	  if($n < (60*60*24*6.5)) return _('circa'). ' ' . round($n/(60*60*24)) . _('giorni').' '.'fa';
	  if($n < (time() - strtotime('last week'))) return _('settimana scorsa');
	  if(round($n/(60*60*24*7))  == 1) return _('circa una settimana fa');
	  if($n < (60*60*24*7*3.5)) return _('circa'). ' ' . round($n/(60*60*24*7)) . _('settimane').' '._('fa');
	  if($n < (time() - strtotime('last month'))) return _('il mese scorso');
	  if(round($n/(60*60*24*7*4))  == 1) return _('circa un mese fa');
	  if($n < (60*60*24*7*4*11.5)) return _('circa'). ' ' . round($n/(60*60*24*7*4)) . _('mesi').' '._('fa');
	  if($n < (time() - strtotime('last year'))) return _("l\'anno scorso");
	  if(round($n/(60*60*24*7*52)) == 1) return _('circa un anno fa');
	  if($n >= (60*60*24*7*4*12)) return _('circa'). ' ' . round($n/(60*60*24*7*52)) . _('anni').' '._('fa'); 
	  return false;
	}
	
}