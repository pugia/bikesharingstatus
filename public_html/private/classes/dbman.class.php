<?php

class dbman {
	
	private $host;
	private $user;
	private $pass;
	private $name;
	private $port = 3306;
	
	private $debug = true;
	
	// l'oggetto connessione
	public $obj = null;
	
	public function __construct($host, $user, $pass, $name, $port = 3306) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->name = $name;
		$this->port = $port;
		
		$this->obj = new mysqli($this->host, $this->user, $this->pass, $this->name, $this->port);
				
	}
	
	public function setDebug($debug) {
		$this->debug = $debug;
	}
	
	public function query($sql) {
		$bt = debug_backtrace();
		$r = ($this->debug) ? $this->obj->query($sql) : @$this->obj->query($sql);
		@$_SESSION['q']++;
		$tpl = '<div style="position:absolute;top:5;left:5;border:1px solid #000;background:#fff;padding:5px">
	<p><strong>Errore MySQL</strong></p>
	<p><strong>Query:</strong></p>
	<pre>__QUERY__</pre>
	<p><strong>Errore:</strong></p>
	<pre>__ENUM__: __ERRORE__</pre>
	<p><strong>File:</strong> '.$bt[0]['file'].'<br /><strong>Linea:</strong> '.$bt[0]['line'].'</p>
	</div>';
			
		if ($this->obj->error && $this->debug) { 
			$tpl = str_replace("__QUERY__", $sql, $tpl);
			$tpl = str_replace("__ENUM__", $this->obj->errno, $tpl);
			$tpl = str_replace("__ERRORE__", $this->obj->error, $tpl);
			die ($tpl);
			//$db->close();
			exit();
		} else {
			return $r;
		}

	}
	
	public function do_queries($sql_array) {
		foreach($sql_array as $sql)	{
			$res = $this->query($sql);
			if(!$res)	return false;
		}
		return true;
	}
	
	public function getColumnFields($table)
	{
		$fields = array();
		/* REPERIMENTO COLONNE DISPONIBILI */
		$sql = sprintf("SHOW COLUMNS FROM %s", $this->res($table));
		$rs = $this->query($sql);
		while($row = $rs->fetch_assoc()) $fields[] = $row['Field'];
		/* FINE REPERIMENTO COLONNE DISPONIBILI */
		return $fields;
	}

	/*
		Returns an insert query in $table based on data found in $data
	and fields in $table
	*/
	public function prepareInsert($table, $data, $ignore = false) {
		$fields = $this->getColumnFields($table);
		$ign = ($ignore) ? 'IGNORE ' : '';
		$insert = array();
		for($i=0;$i<count($fields);$i++)
		{
			if(isset($data[$fields[$i]]))
			{
				$insert[$fields[$i]] = $this->res((string)$data[$fields[$i]]);
			}
		}
		$sql = "INSERT ".$ign."INTO ".$this->res($table)." (".implode(", ",array_keys($insert)).") ";
		$sql .= " VALUES ('".implode("', '",array_values($insert))."')";

		return $sql;
	}
	
	/*
		Returns an insert query in $table based on data found in $data
	and fields in $table
	*/
	public function prepareUpdate($table, $data, $where) {
		$fields = $this->getColumnFields($table);
		$insert = array();
		for($i=0;$i<count($fields);$i++)
		{
			if(isset($data[$fields[$i]]))
			{
				$insert[$fields[$i]] = $this->res($data[$fields[$i]]);
			}
		}

		$sql = "UPDATE ".$this->res($table).' SET ';
		foreach ($insert as $k=>$v) {
			$sql .= sprintf("%s = '%s', ", $k, $v);
		}
		$sql = substr($sql,0,-2);
		$sql .= ' WHERE 1 ';
		
		foreach ($where as $k=>$v) {
			$sql .= sprintf(" AND %s = '%s'", $k, $v);
		}

		return $sql;
	}
	
	public function result2array($rs)	{
		$ret = array();
		if ($rs->num_rows) {
			while ($d = $rs->fetch_assoc())
				$ret[] = $d;
		}
		return (count($ret) == 1) ? $ret[0] : $ret;
	}
	
	public function res($string, $trailingQuote = false) {

		if (is_array($string)) {
			
			foreach ($string as $key => $single_string) {
				
				$string[$key] = $this->res($single_string);

			}

			return $string;

		}

		if (is_null($string) && $trailingQuote) {
			return 'NULL';
		} else {
			return ($trailingQuote) ? "'".$this->obj->real_escape_string($string)."'" : $this->obj->real_escape_string($string);
		}
	}
	
	public function insert_id() {
		return $this->obj->insert_id;
	}
	
	public function affected_rows() {
		return $this->obj->affected_rows;
	}
	
}
