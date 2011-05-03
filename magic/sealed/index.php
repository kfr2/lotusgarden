<?php
error_reporting(0);

$dbname = "/home/kevin/maintenance/sealed_magic.db";

// connect to the database
$base = new SQLite3($dbname, SQLITE3_OPEN_READWRITE);

// include required libraries
include("../lib/printlib.php");
include("../lib/mwslib.php");

// if the user has entered a deck URL (?deck={id}) then load that deck
if(isset($_GET['deck']))
{
	$deck_id = $_GET['deck'];
	if(is_numeric($deck_id)){ display_mainpage($deck_id); }
}


// else, generate a new deck for them
else { display_mainpage(); }

// close SQL database
$base->close();

?>
