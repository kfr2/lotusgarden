<?php
/** ----------------------------------------------------------
// given a $deck_id, retrieve all the cards from the database
// and call createMWDeck()
// -----------------------------------------------------------
**/

$dbname = "/home/kevin/maintenance/sealed_magic.db";

// include required libraries
include("../lib/mwslib.php");

if(!isset($_GET['deck'])){ die("You need to input a deck id."); }
if(is_numeric($_GET['deck'])){ $deck_id = $_GET['deck']; }
else{ die("Valid deck id, please."); }

// connect to the database
$base = new SQLite3("$dbname");

// if the deck id doesn't exist, exit
if($base->querySingle("SELECT id FROM decks WHERE id=$deck_id") == 0){ die("Invalid Deck ID."); }

// get the cards in this $deck_id
$results = $base->query("SELECT card_id FROM decks WHERE id=$deck_id");

$i = 0;
while($res = $results->fetchArray(SQLITE3_ASSOC))
{
	$cards[] = $res['card_id'];
	$i++;
}


// create the deck!
createMWDeck($cards);

$base->close();

?>
