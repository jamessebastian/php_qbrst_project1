<?php
/**
* gets the names of states for displaying 
*
* @return object
*/ 
function getStates()
{
	global $conn;
	$sql = "SELECT id, name FROM states";
	return $conn->query($sql);
}

?>