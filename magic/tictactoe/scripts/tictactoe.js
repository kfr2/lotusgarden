var cellValues;
var turnInfo;
var faction;
var gameDisabled;
var numPiecesPlaced;
var gameboard;
var announcement;
var sideSelection;
var phyrexiaScore = 0;
var mirrodinScore = 0;
var drawScore = 0;

// called when the page finishes loading
function load() {
	// establish the pieces of the board
	announcement = document.getElementById("announcement");

	faction = "";
	turnInfo = document.getElementById("turnInfo");
	sideSelection = document.getElementById("sideSelection");

	gameboard = document.getElementById("gameboard");
	cellValues = [	[0,0,0],
					[0,0,0],
					[0,0,0]];

	gameDisabled = false;
	numPiecesPlaced = 0;

	// add onClick handlers to each cell

	newGame();
}

// begins the process for creating a new game
function newGame() {
	// reset the board
	gameDisabled = false;

	numPiecesPlaced = 0;

	for(var i = 0; i < 3; i++) {
		for(var j = 0; j < 3; j++) {
			cellValues[i][j] = 0;
			document.getElementById("r" + i + j).setAttribute("class", ""); 
		}
	}
	// establish initial board state
	gameboard.style.display = "none";
	turnInfo.style.display = "none";

	announcement.innerHTML = "Choose your side!";
	sideSelection.style.display = "block";

}

// allows the user to choose which side he or she would like to fight for!
function chooseSide(userFaction) {
	if(userFaction == "Mirrodin"){ faction = "Mirrodin"; }
	else{ faction = "Phyrexia"; }

	announcement.innerHTML = "Fight for all that is " + faction + "!";

	turnInfo.innerHTML = "It is " + faction + "'s turn.";
	sideSelection.style.display = "none";
	turnInfo.style.display = "block";

	gameboard.style.display = "block";

	// see if the computer should make a move by generating a random
	// number between 1 and 10. computer goes first from 1-5 inclusive
	if(Math.floor(Math.random() * 10 + 1) < 6){
		computerMove();
	}
}

// user is placing a piece into rowId
function playerMove(rowId) {
	var validMove = placePiece(rowId, faction);

	if(validMove){
		computerMove();
	}
}

// returns an array containing the available spaces on the board
function remainingMoves() {
	var remainingMoves = new Array();

	for(var i = 0; i < cellValues.length; i++) {
		for(var j = 0; j < cellValues[i].length; j++) {
			if(cellValues[i][j] == 0) {
				remainingMoves.push(i + "" +  j);
			}
		}
	}

	return remainingMoves;
}

// chooses the best position for the computer's next move, based on
// the remainingMoves possible
function bestMove(remainingMoves) {
	var computerMove;

	// stores the value of a row in which the computer already has two
	// existing pieces
	var computerGoal;
	faction == "Mirrodin" ? computerGoal = 2 : computerGoal = -2;

	for(var i = 0; i < remainingMoves.length; i++) {
		var cell = remainingMoves[i];
		var row = cell.charAt(0);
		var col = cell.charAt(1);

		// examine horizontally
		var rowSum = cellValues[row][0] + cellValues[row][1] + cellValues[row][2];
		// see if computer is the winner 
		if(rowSum == computerGoal){
			computerMove = "r" + remainingMoves[i]; 
			return computerMove; 	
		}
		// see if computer needs to block opponent's potential winner
		else if(rowSum == (computerGoal * -1)) {
			computerMove = "r" + remainingMoves[i]; 
			return computerMove;	
		}

		
		// examine vertically
		var colSum = cellValues[0][col] + cellValues[1][col] + cellValues[2][col];
		// see if computer is the winner
		if(colSum == computerGoal){
			computerMove = "r" + remainingMoves[i]; 
			return computerMove;
		}
		// see if comp. needs to block opponent's potential winner
		else if(colSum == (computerGoal * -1)) {
			computerMove = "r" + remainingMoves[i];
			return computerMove;
		}
		
		// examine diagonally (if applicable)
		var diagSum;
		if((row == 0 && col == 0) || (row == 1 && col == 1) || (row == 2 && col == 2)){
			diagSum = cellValues[0][0] + cellValues[1][1] + cellValues[2][2];
			if(diagSum == computerGoal){
				computerMove = "r" + remainingMoves[i];
				return computerMove;
			}

			else if(diagSum == (computerGoal * -1)) {
				computerMove = "r" + remainingMoves[i];
				return computerMove;
			}
		}

		else if((row == 2 && col == 0) || (row == 1 && col == 1) || (row == 0 && col == 2)) {
			diagSum = cellValues[2][0] + cellValues[1][1] + cellValues[0][2];
			if(diagSum == computerGoal){
				computerMove = "r" + remainingMoves[i];
				return computerMove;
			}

			else if(diagSum == (computerGoal * -1)) {
				computerMove = "r" + remainingMoves[i];
				return computerMove;
			}
	
		}
	}
	

	// otherwise, a suitable position was not found. return a random one.
	computerMove = randomMove(remainingMoves);

	return computerMove; 
}


// the AI is placing a piece. rowId determined inside this function.
// utilizes fuzzy logic to try to "block" any path the player is trying
// to take to victory.
function computerMove() {
	var opponentFaction;
	faction == "Mirrodin" ? opponentFaction = "Phyrexia" : opponentFaction = "Mirrodin";
	
	// choose the best position to move based on remaining moves
	var computerMove = bestMove(remainingMoves());

	// sleep for half a second
	startTime = new Date().getTime();
	while(new Date().getTime() < startTime + 500);

	// place the chosen piece
	placePiece(computerMove, opponentFaction);
}

// chooses a random position out of the remainingMoves
function randomMove(remainingMoves) {
	var randomInt = Math.floor(remainingMoves.length * Math.random());
	var randomMove = "r" + remainingMoves[randomInt];

	return randomMove;
}

function placePiece(rowId, faction) {
	var id = document.getElementById(rowId);

	// if this cell has already been selected, don't allow the user to choose it
	var row = rowId.charAt(1);
	var col = rowId.charAt(2);

	if(cellValues[row][col] == 0 && !gameDisabled){
		faction == "Mirrodin" ? factionBackground = "mirranBackground" : factionBackground = "phyrexianBackground";
		id.setAttribute("class", factionBackground);

		faction == "Mirrodin" ? value = -1 : value = 1;

		faction == "Mirrodin" ? faction = "Phyrexia" : faction = "Mirrodin";

		//announcement.innerHTML = "It is " + faction + "'s turn.";
		//turnInfo.innerHTML = "It is " + faction + "'s turn.";
		turnInfo.innerHTML = "&nbsp;";

		cellValues[row][col] = value;

		numPiecesPlaced++;

		// see if a winner exists (or if we have a draw)
		if(!checkWinner() && numPiecesPlaced == 9){
			drawScore++;
			document.getElementById("drawScore").innerHTML = drawScore;

			announcement.innerHTML = "The War Continues!";
			turnInfo.innerHTML = "This battle has ended in a draw. <a href='javascript:newGame()'>Try again</a>!";

			return false;
		}

		return true;

	}

	else{ return false; }
}

// determines if we have a winner!
function checkWinner() {
	var winnerName = "";
	var winner = false;

	var rowSums = new Array();
	var count = 0;
	var sum = 0;

	// each row & column
	for(var i = 0; i < 3; i++){

		var sum1 = 0;
		var sum2 = 0;

		for(var j = 0; j < 3; j++){
			sum1 += cellValues[i][j];
			sum2 += cellValues[j][i];
		}

		rowSums[count++] = sum1;
		rowSums[count++] = sum2;
	}

	// both diagonals
	rowSums[count++] = cellValues[0][0] + cellValues[1][1] + cellValues[2][2];
	rowSums[count++] = cellValues[2][0] + cellValues[1][1] + cellValues[0][2];

	// see if there are any winners (sum of -3 or 3)
	for(var i = 0; i < rowSums.length; i++){
		if(rowSums[i] == -3){
			winnerName = "Mirrodin";
			winner = true;
			break;
		}

		else if(rowSums[i] == 3){
			winnerName = "Phyrexia";
			winner = true;
			break;
		}
	}

	if(winner){
		announcement.innerHTML = winnerName + " has won the battle!";

		if(winnerName == "Mirrodin"){
			mirrodinScore++;
			document.getElementById("mirrodinScore").innerHTML = mirrodinScore;

			turnInfo.innerHTML = "We will endure!  ";
		}

		else{
			phyrexiaScore++;
			document.getElementById("phyrexiaScore").innerHTML = phyrexiaScore;

			turnInfo.innerHTML = "All will be one!  ";
		}

		turnInfo.innerHTML += "<a href='javascript:newGame()'>Battle again</a>";
		gameDisabled = true;

		return true;
	}
}

// swaps reset image to on-hover position
function swapResetOn() {
	document.getElementById('reset-icon').setAttribute("src", "images/reset-icon-2.png");
}

// swaps reset image to non-hover position
function swapResetOff() {
	document.getElementById('reset-icon').setAttribute("src", "images/reset-icon-1.png");
}

function swapResetClick() {
	document.getElementById('reset-icon').setAttribute("src", "images/reset-icon-3.png");
}
