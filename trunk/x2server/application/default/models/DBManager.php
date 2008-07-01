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
    		or die("Fehler in DBManager->__construct: Keine Verbindung möglich: " . mysql_error());
    	
    	mysql_select_db($this->mysql_db) 
    		or die("Fehler in DBManager->__construct: Auswahl der Datenbank fehlgeschlagen");
	}
	
	function __destruct() {
		mysql_close($this->link);
	}
	
	function getImage($UserID, $Tag, $AverageColor){
		$query = 'SELECT x2_photos.ID, x2_tags.Name, x2_photos.AverageColor
		FROM x2_photos, x2_mapping, x2_tags
		WHERE x2_photos.ID = x2_mapping.PhotoID
		AND x2_mapping.TagID = x2_tags.ID
		AND x2_tags.Name = $Tag 
		AND x2_photos.AverageColor = $AverageColor
		AND x2_photos.UserID = $UserID';
		$result = mysql_query($query) 
			or die("Fehler in DBManager: Anfrage fehlgeschlagen: " . mysql_error());
		$row = mysql_fetch_object($result);	
		return $row;
	}
	
	function addImage($ID, $AverageColor, $UserID, $Tags){
		 $query = "INSERT INTO x2_photos (ID, AverageColor, UserID) 
		 		  VALUES ('$ID', '$AverageColor', '$UserID')";
		 $result = mysql_query($query) 
		 	or die('Fehler in DBManager->addImage: Kann Bild mit ID $ID nicht eintragen.');
		 
	}
	
	// TODO fix!
	
	function getTagID($TagString){
		 $query = "SELECT ID FROM `x2_tags` WHERE Name = '".$TagString."' LIMIT 1";
		 $result = mysql_query($query) 
		 	or die('Fehler in DBManager->getTagID');
		 $row = mysql_fetch_object($result);
		 if(sizeof($row)==1){
		 	echo "1";
		 	return $row[0];
		 } else {
		 	echo "0";
		 	mysql_query("INSERT INTO x2_tags (Name) VALUES ('".$TagString."')")
		 		or die ('Fehler in DBManager->getTagID: Kann Tag nicht eintragen');
		 	$query = "SELECT ID FROM `x2_tags` WHERE Name = '".$TagString."' LIMIT 1";
		 	$result = mysql_query($query) 
		 		or die('Fehler in DBManager->getTagID');
		 	$row = mysql_fetch_object($result);
		 	return  $row[0];
		 }
	}
	
	/**
	 * Pushes a  PhotoID to the queue with all elements to index.
	 */
	
	function queuePush($IDs){
		$IDs=$this->convert($IDs);
		$query = "INSERT IGNORE INTO x2_queue (ID) VALUES ".$IDs;
		$result = mysql_query($query) 
			or die("Fehler in DBManager->addImage: Kann Bilder " .$IDs. " nicht in queue eintragen.");
	}
	
	/**
	 * Gets $limit elements from the bottom of the queue-stack.
	 */
	
	function queuePop($limit){
		$result = mysql_query("SELECT * FROM `x2_queue` ORDER BY x2_queue.ID LIMIT " . $limit)
		 	or die('Fehler in DBManager->queuePop: Die bei mysql_query.');
		while($row = mysql_fetch_object($result))
	    {
	    	mysql_query("DELETE FROM `x2_queue` WHERE ID = " . $row->ID)
	    		or die ('Fehler in DBManager->queuePop: Kann ID' . $row->ID . 'ID nicht löschen');
	    }
	    return $row;		
	}
	
	/**
	 * Converts a one-dimensional array("a","b","c") to a String "(a), (b), (c)" for MySQL Queries
	 */
	
	private function convert($Strings){
		foreach($Strings as $String){
		if($n>0){
			$return .= ", ";
		}
		$return .= "(".$String.")";
		$n++;
		}
		return $return;
	}
}

$dbmanager = new DBManager();
//$dbmanager->queuePush(array(rand(1,100),rand(1,100)));
//$dbmanager->addImage("1","1","1");
//echo $dbmanager->getTagID("Ort");
