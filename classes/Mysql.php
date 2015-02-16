<?php

/**
* Generation of page of an error at access out of system
* Генерация страницы ошибки при доступе вне системы
*/
if(!defined('IRB_KEY'))
{
	header("HTTP/1.1 404 Not Found");
	exit();
} 

global $mysql;
if (!isset($mysql)) {
	$mysql = new Mysql();
}

class Mysql {
	var $dbc;

	function Mysql() {
		$this->dbc = mysql_connect(IRB_DBSERVER, IRB_DBUSER, IRB_DBPASSWORD) or die("Could not connect: " . mysql_error());
		mysql_select_db(IRB_DATABASE, $this->dbc) or die ('Can\'t use DB : ' . mysql_error());
		mysql_query("SET NAMES 'utf8'", $this->dbc); 
	}

	function execute() {
		$arguments = func_get_args();
		if (is_array($arguments[0])) {
			$arguments = $arguments[0];
		}
		
		$query = array_shift($arguments);
		$params = array();
		
		foreach ($arguments as $list_param) {
			if (is_array($list_param)) {
				foreach ($list_param as $array_param) {
					$params[]=$array_param;
				}
			} else {
				$params[]=$list_param;
			}
		}

		$params_index = count($params)-1;
		for ($i=strlen($query)-1; $i>0; $i--) {
			if ($query[$i] !== '?') {
				continue;
			}
			$param = $params[$params_index];
			if (isset($param)) {
				if (get_magic_quotes_gpc()) {
					$param = stripslashes($param);
				}
				$param = "'".mysql_real_escape_string($param)."'";
				$query = substr_replace($query, $param, $i, 1);
			} else {
				$query = substr_replace($query, 'null', $i, 1);
			}
			$params_index--;
		}
		
		$result = mysql_query($query, $this->dbc) or die("Invalid query: " . mysql_error()."\n QUERY: $query");

		return $result;
	}

	function last_id($table = null) {
		if(isset($table)){
			$result = mysql_query("select last_insert_id() AS last_id from ".$table, $this->dbc) 
				or die("Invalid query: " . mysql_error());
			$row = mysql_fetch_row($result);
			return $row[0];
		} else {
			return mysql_insert_id($this->dbc);
		}
	}

	function get_array() {
		$resource = $this->execute(func_get_args());
		$array = array();
		while($row=mysql_fetch_array($resource,MYSQL_ASSOC)) {
			$array[]=$row;
		}
		mysql_free_result($resource);
		return $array;
	}
	
	function get_row () {
		$resource = $this->execute(func_get_args());
		$row = mysql_fetch_array($resource, MYSQL_ASSOC);
		mysql_free_result($resource);
		return $row;
	}
}