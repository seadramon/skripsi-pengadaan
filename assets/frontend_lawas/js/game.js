// the game itself
var game;
// the spinning wheel
var wheel;
// can the wheel spin?
var canSpin;
// slices (prizes) placed in the wheel
var slices = 8;
// prize names, starting from 12 o'clock going clockwise
var slicePrizes = ["Mug", "Putar Lagi", "Notebook", "Powerbank", "Mug", "Kosong", "Notebook", "Powerbank"];
// the prize you are about to win
var prize;

window.onload = function() {
	// creation of a 458x488 game
	game = new Phaser.Game(458, 500, Phaser.AUTO, 'wof', '', true);
	// adding "PlayGame" state
	game.state.add("PlayGame",playGame);
	// launching "PlayGame" state
	game.state.start("PlayGame");
};

// PLAYGAME STATE
var playGame = function(game){};

playGame.prototype = {
    // function to be executed once the state preloads
    preload: function(){
		// preloading graphic assets
		game.load.image("wheel", "http://jayadata.com/mataharimall/assets/frontend/img/wheel.png");
		game.load.image("pin", "http://jayadata.com/mataharimall/assets/frontend/img/pin.png");
    },

    // funtion to be executed when the state is created
  	create: function(){
		// adding the wheel in the middle of the canvas
		wheel = game.add.sprite(game.width / 2, game.width / 2, "wheel");
		// setting wheel registration point in its center
		wheel.anchor.set(0.5);
		// adding the pin in the middle of the canvas
		var pin = game.add.sprite(game.width / 2, game.width / 2, "pin");
		// setting pin registration point in its center
		pin.anchor.set(0.5);
		// the game has just started = we can spin the wheel
		canSpin = true;
		// waiting for your input, then calling "spin" function
		game.input.onDown.add(this.spin, this);
	},

    // function to spin the wheel
    spin(){
		// can we spin the wheel?
		if(canSpin){
			// the wheel will spin round from 2 to 4 times. This is just coreography
			var rounds = game.rnd.between(2, 4);
			// then will rotate by a random number from 0 to 360 degrees. This is the actual spin
			var degrees = game.rnd.between(0, 359);
			// before the wheel ends spinning, we already know the prize according to "degrees" rotation and the number of slices
			prize = slices - 1 - Math.floor(degrees / (360 / slices));
			// now the wheel cannot spin because it's already spinning
			canSpin = false;
			// animation tweeen for the spin: duration 3s, will rotate by (360 * rounds + degrees) degrees
			// the quadratic easing will simulate friction
			var spinTween = game.add.tween(wheel).to({
			angle: 360 * rounds + degrees
			}, 3000, Phaser.Easing.Quadratic.Out, true);
			// once the tween is completed, call winPrize function
			spinTween.onComplete.add(this.winPrize, this);
			// log it
			//console.log("Spinned");
        }
    },

    // function to assign the prize
    winPrize(){
		// writing the prize you just won
		prize = slicePrizes[prize];

		// now we can spin the wheel again
		if((prize === "Putar Lagi") || (prize === "")){
			canSpin = true;
			$('#prize, #prizeResult').html(prize);
			$('#chanceTrigger').click();
			//console.log("Prize: " + prize);
			//console.log("Can Spin");
		} else if ((prize === "Kosong")) {
			canSpin = false;
			$('#prize, #prizeResult').html(prize);
			$('#zonkTrigger').click();
			//console.log("Prize: " + prize);
			//console.log("Can't Spin");
		} else {
			canSpin = false;
			$('#prize, #prizeResult').html(prize);
			$('#winningTrigger').click();
			//console.log("Prize: " + prize);
			//console.log("Can't Spin");
		}
     }
};
