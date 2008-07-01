<?php

require_once 'DBParameter.php';

class DBManager {
	
	private $mysql_host;
	private $mysql_user;
	private $mysql_password;
	private $mysql_db;
	
	function __construct() {
		
		$this->mysql_host = DBParameter::$mysql_host;
		$this->mysql_user = DBParameter::$mysql_user;
		$this->mysql_password = DBParameter::$mysql_password;
		$this->mysql_db = DBParameter::$mysql_db;
		
		$this->link = mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_password)
    		or die("Keine Verbindung möglich: " . mysql_error());
    	
    	mysql_select_db($this->mysql_db) 
    		or die("Auswahl der Datenbank fehlgeschlagen");
	}
	
	function __destruct() {
		mysql_close($this->link);
	}
	
	function get(){
		$query = "SELECT x2_photos.ID, x2_tags.Name, x2_photos.AverageColor
		FROM x2_photos, x2_mapping, x2_tags
		WHERE x2_photos.ID = x2_mapping.PhotoID
		AND x2_mapping.TagID = x2_tags.ID
		AND x2_tags.Name = 'Bielefeld'
		AND x2_photos.AverageColor = '11111111'";
		$result = mysql_query($query) 
			or die("Anfrage fehlgeschlagen: " . mysql_error());
		while($row = mysql_fetch_object($result))
	    {
	  		echo $row->ID;
	    }		
	}
}

$dbmanager = new DBManager();
$dbmanager->get();

