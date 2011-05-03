<?php

/** ----------------------------------
/   creates MWS files, etc
/   K. Richardson <borismalcov@users.sf.net>
/   ----------------------------------
**/

// creates a magic workstation .mwDeck file from an array of card ids
function createCockatriceDeck($cards)
{
	// connect to the sqlite database
	global $base;

	// generate a name for the deck
	$deck_name = time() . ".cod";

	// make the browser interpret this as a download
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"$deck_name\"");

	$to_print = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$to_print .= "<cockatrice_deck version=\"1\">\n";
	$to_print .= "\t<deckname>Sealed " . time() . "</deckname>\n";
	$to_print .= "\t<comments>Generated at http://kevin.triageworks.net/sealed/</comments>\n";

	// add all the cards to the main deck
	 $to_print .= "\t<zone name=\"main\">\n";

	foreach($cards as $card_id => $num_card)
	{
		$card_name  = $base->querySingle("SELECT name FROM cards WHERE id=$card_id");
               	$to_print .= "\t\t<card number=\"$num_card\" name=\"$card_name\"/>\n";
	}

	$to_print .= "\t</zone>\n";
	$to_print .= "</cockatrice_deck>";

	// close the SQLite DB connection
	$base->close();

	// return the file to the user
	print($to_print);
}

?>
