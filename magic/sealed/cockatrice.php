<?php
/** ----------------------------------------------------------
// given a $deck_id, retrieve all the cards from the database
// and call createMWDeck()
// -----------------------------------------------------------
**/

$dbname = "/home/kevin/maintenance/sealed_magic.db";

// include required libraries
include("../lib/cockatricelib.php");

if(!isset($_GET['deck'])){ die("You need to input a deck id."); }
if(is_numeric($_GET['deck'])){ $deck_id = $_GET['deck']; }
else{ die("Valid deck id, please."); }

// connect to the database
$base = new SQLite3("$dbname");

// if the deck id doesn't exist, exit
if($base->querySingle("SELECT id FROM decks WHERE id=$deck_id") == 0){ die("Invalid Deck ID."); }

// get the cards in this $deck_id
$results = $base->query("SELECT card_id FROM decks WHERE id=$deck_id");

// create array to store cards in
$cards = array();

while($res = $results->fetchArray(SQLITE3_ASSOC))
{
	$card_id = $res['card_id'];

	// if the card is not already in the array, count how many are
	// in the pool then add to the array
	if(!in_array($res['card_id'], $cards)){
		$num_card = $base->querySingle("SELECT COUNT(card_id) FROM decks WHERE id=$deck_id AND card_id = $card_id");
		$cards[$card_id] = $num_card;
	}

}

// sort the array by card id
ksort($cards, SORT_NUMERIC);

// create the deck!
createCockatriceDeck($cards);

$base->close();

?>
