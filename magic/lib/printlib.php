<?php

/**
 * prints the basic webpage header
 */
function display_header($title)
{
$text = <<< EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>{$title}</title>
<meta http-equiv="content-language" content="en" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="description" content="A Magic: the Gathering Scars of Mirrodin and Mirrodin Besieged sealed deck generator." />
<link rel="stylesheet" href="/magic/style/print.css" type="text/css" media="print" />
<link rel="stylesheet" href="/magic/style/main.css" type="text/css" media="all" />
	<script type="text/javascript"> 
 
  		var _gaq = _gaq || [];
  		_gaq.push(['_setAccount', 'UA-21050532-1']);
  		_gaq.push(['_trackPageview']);
 
  		(function() {
    		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  		})();
 
	</script> 

<!-- many thanks to the handy script from deckbox.org/help/tooltips -->
<script src="http://deckbox.org/javascripts/bin/tooltip.js"></script>
</head>
<body>
<div class="container">
EOT;

print($text);
}

/**
 * prints the basic webpage header
 */
function display_footer()
{
$text = <<< EOT
\n</div>
</body>
</html>
EOT;

print($text);
}

function display_copyright()
{
	print("<div class=\"copyright\">Magic: the Gathering, its respective card images, and essentially everything else about it belong to Wizards of the Coast. This site is merely a labor of love. </div>");
}

/**
 * Prints a user's mainpage. Going to be moved into display_content for easy http redirection upon sealed generation
 */
function display_mainpage($deck_id="")
{
	display_header("New Phyrexia sealed generator.");
	display_menu();
	print("<div class=\"container2\">"); display_content($deck_id); print("</div>");
	display_copyright();
	display_footer();
}

/**
 * displays the content for a user
 */
function display_content($deck_id)
{
   // we need access to the $db
   global $base;

   // did the user input a valid deck id? if so, display it.
   if($deck_id != "")
   {
      // get all the cards from the deck database and pull their info
      // from the card database (creating a card object with this second query)

	// if the deck id doesn't exist, exit
	if($base->querySingle("SELECT id FROM decks WHERE id=$deck_id") == 0){ die("Invalid Deck ID."); }

	$to_print = "";

	// print out the pack breakdown
	for($i = 1; $i <= 6; $i++)
	{

		$to_print .= "<b>Pack " . $i . "</b><br />";

		$cards = $base->query("SELECT card_id, card FROM decks WHERE id=$deck_id AND pack=$i ORDER BY card");
	
		while($card = $cards->fetchArray(SQLITE3_ASSOC))
		{
			// use the card ID to get the card name from the database
			// could be used later to get more information
			$id = $card['card_id'];
			$pick = $card['card'];
			$name = $base->querySingle("SELECT name FROM cards WHERE id=$id");
			$foiled = $base->querySingle("SELECT foil FROM decks WHERE id=$deck_id AND pack=$i AND card=$pick AND card_id=$id");

			if($foiled == 1){ $to_print .= "<b>"; }
			$to_print .= "<a href=\"http://deckbox.org/mtg/$name\">" . $name . "</a><br />";
			if($foiled == 1){ $to_print .= "</b>"; }
		}

		$to_print .= "<hr style=\"width: 15em;\" align=\"left\" />";
}

	// add a link to the deck, MWS file, and Cockatrice FIle
	$to_print .= "<a href=\"index.php?deck=$deck_id\">permalink</a>";
	$to_print .= "<br /><a href=\"mws.php?deck=$deck_id\">MWS file</a>";
	$to_print .= "<br /><a href=\"cockatrice.php?deck=$deck_id\">Cockatrice file</a>";

	print($to_print);
   }

   // else, generate a new one for them
	else {

                // figure out which ID to give this deck (max+1)
                $deck_id = $base->querySingle("SELECT MAX(id) FROM decks") + 1;


		// generate 6 booster packs
		for($i = 1; $i <= 6; $i++){

			// 3 of SOM; 3 of MBS
			if($i >= 1 && $i <= 3){ $set_id = 1; }
			else{ $set_id = 3; }
			$cards = array();

			// 15 cards in each pack...

			print("<b>Pack " . $i . "</b><br />");

			// generate the basic land first
			$land = $base->query("SELECT id FROM cards WHERE type LIKE 'Basic Land%' AND set_id = {$set_id} ORDER BY Random() LIMIT 1");
			while($row = $land->fetchArray()){
	                        $base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 0, $i, 1)");
				$cards[] = $row[0];
			}

			// see if we need a foil card. if so, it replaces
			// a common. 1 in 5 probability
			if(rand(1,5) == 5){
				// foil mythic?  1:8 probability.
				if(rand(1,8) == 8){
					$mythic = $base->query("SELECT id FROM cards WHERE RARITY = 'M' AND set_id = {$set_id} ORDER BY Random() LIMIT 1");
					while($row = $mythic->fetchArray()){
			                        // insert it into the database
                        			$base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 1, $i, 2)");
						$cards[] = $row[0];
					}
				}

				else{
					$foil = $base->query("SELECT id FROM cards WHERE TYPE NOT LIKE 'Basic Land%' AND RARITY != 'M' AND set_id = {$set_id} ORDER BY RANDOM() LIMIT 1");
					while($row = $foil->fetchArray()){
	                        		// insert it into the database
        			                $base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 1, $i, 2)");
						$cards[] = $row[0];
					}
				}

				// generate 9 commons (but not lands)
				$commons = $base->query("SELECT id FROM cards WHERE rarity = 'C' AND TYPE NOT LIKE 'Basic Land%' AND set_id = {$set_id} ORDER BY Random() LIMIT 9");
				$j = 3;
				while($row = $commons->fetchArray())
				{
	                                $base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 0, $i, $j)");
					$cards[] = $row[0];
					$j++;
				}
			}

			// no foil. generate 10 commons (but not lands)
			else{
				$commons = $base->query("SELECT id FROM cards WHERE rarity = 'C' AND TYPE NOT LIKE 'Basic Land%' AND set_id = {$set_id} ORDER BY Random() LIMIT 10");
				$j = 2;
				while($row =  $commons->fetchArray())
				{
	                                $base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 0, $i, $j)");
					$cards[] = $row[0];
					$j++;
				}
			}


			// generate 3 uncommons
			$uncommons = $base->query("SELECT id FROM cards WHERE rarity = 'U' AND set_id = {$set_id} ORDER BY Random() LIMIT 3");
			$j = 12;
			while($row = $uncommons->fetchArray())
			{
                                $base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 0, $i, $j)");
				$cards[] = $row[0];
				$j++;
			}


			// mythic probability: 1:8. replaces rare
			if(rand(1,8) == 8){
				$mythic = $base->query("SELECT id FROM cards WHERE rarity = 'M' AND set_id = {$set_id} ORDER BY Random() LIMIT 1");
				while($row = $mythic->fetchArray()){
                                	$base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 0, $i, 15)");
					$cards[] = $row[0];
				}
			}

			// give 'em a rare
			else{
				$rare = $base->query("SELECT id FROM cards WHERE rarity = 'R' AND set_id = {$set_id} ORDER BY Random() LIMIT 1");
				while($row = $rare->fetchArray()) {
                                	$base->exec("INSERT INTO decks (id, card_id, foil, pack, card) VALUES ($deck_id, $row[0], 0, $i, 15)");
					$cards[] = $row[0];
				}
			}

		// print out their names by pulling IDs/names from the DB
		// current pack number is $i and pick is $j
		$j = 1;
		foreach($cards as $card){
			// get the card name and foiled state
			$card_name = $base->querySingle("SELECT name FROM cards WHERE id=$card");
                        $foiled = $base->querySingle("SELECT foil FROM decks WHERE id=$deck_id AND pack=$i AND card=$j AND card_id=$card");

			if($foiled == 1){ print("<b>"); }
			print("<a href=\"http://deckbox.org/mtg/$card_name\">" . $card_name . "</a><br />");
			if($foiled == 1){ print("</b>"); }

			$j++;
		}

		print("<hr style=\"width: 15em;\" align=\"left\" />");

		} // end for loop that generates booster packs

	// generate a permalink and a MWS link
	print("<a href=\"index.php?deck=$deck_id\">permalink</a>");
	print("<br /><a href=\"mws.php?deck=$deck_id\">MWS file</a>");
	print("<br /><a href=\"cockatrice.php?deck=$deck_id\">Cockatrice file</a>");



	} // end else
}

/**
 * displays a menu for the user. used for random flavor text?
 */
function display_menu()
{
	print("<div class=\"menu\" id=\"menu\">");
	print("<strong>3 Packs of Scars of Mirrodin and 3 Packs of Mirrodin Besieged.</strong><br />");
	print("<i>Some convictions are so strong that the world must break to accommodate them.</i><br /><br />");
	print("<a href=\"http://kevin.triageworks.net\">Kevin's home page</a> | <a href=\"/magic/sealed/\">sealed generator</a> | ");
	print("<a href=\"/magic/tictactoe/\">tictactoe</a>");
	print("</div>");
}

?>
