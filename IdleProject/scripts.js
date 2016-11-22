
//initialize variables
var scrap = {
	name:"scrap",
	total:0,
	increment:1
},
gas = {
		name:"gas",
		total:0,
		increment:1
},
radioactive = {
	name:"radioactive",
	total:0,
	increment:1
},
droidPop = {
	total:0,
	cap:0
},
droid = {
	scrapCost:20,
	gasCost:20,
	radCost:20
},
scrapper = {
	total:0,
	increment:0.5
},
extractor = {
	total:0,
	increment:0.5
},S
miner = {
	total:0,
	increment:0.5
},
scrapDrill = {
	total:0,
	cost:{
		scrap:500,
		gas:500,
		radioactive:500
	}
},
gasDrill = {
	total:0,
	cost:{
		scrap:500,
		gas:500,
		radioactive:500
	}
},
radDrill = {
	total:0,
	cost:{
		scrap:500,
		gas:500,
		radioactive:500
	}
},
droidFactory = {
	total:0,
	cost:{
		scrap:1000,
		gas:1000,
		radioactive:1000
	}
};

//gameloop
window.setInterval(function(){
	generateResources();
	updateBars();
	updateNumbers();
}, 1000);

//add resources when clicking a resource button
function increment(resource){
	resource.total += resource.increment +=10;
	updateNumbers();
}

//generate resources each second from workers and buildings
function generateResources(){
	var netScrap = scrapper.total * scrapper.increment;
	scrap.total += scrapper.total * scrapper.increment;
	document.getElementById("net-scrap").innerHTML = netScrap;
	
	var netGas = extractor.total * extractor.increment;
	gas.total += extractor.total * extractor.increment;
	document.getElementById("net-gas").innerHTML = netGas;
	
	var netRad = miner.total * miner.increment;
	scrap.total += miner.total * miner.increment;
	document.getElementById("net-rad").innerHTML = netRad;
}

function buyDroid(){
	if(scrap.total >= droid.scrapCost && gas.total >= droid.gasCost && radioactive.total >= droid.radCost){
		scrap.total -= 20;
		gas.total -= 20;
		radioactive.total -= 20;
		droidPop.total++;
		updateNumbers();
	}
}

function build(item){
	if(scrap.total >= item.cost.scrap && gas.total >= item.cost.gas && radioactive.total >= item.cost.radioactive){
		scrap.total -= item.cost.scrap;
		gas.total -= item.cost.gas;
		radioactive.total -= item.cost.radioactive;
		item.total++;
		
		document.getElementById("scrap-total").innerHTML = Math.round(scrap.total);
		document.getElementById("gas-total").innerHTML = Math.round(gas.total);
		document.getElementById("radioactive-total").innerHTML = Math.round(radioactive.total);
		document.getElementById("scrpDrills").innerHTML = scrapDrill.total;
		document.getElementById("gasDrills").innerHTML = gasDrill.total;
		document.getElementById("radDrills").innerHTML = radDrill.total;
		document.getElementById("droidFacts").innerHTML = droidFactory.total;
	}
}

//assign droid to worker type
function assignDroid(droidType){
	if(droidPop.total > 0){
		droidPop.total--;
		droidType.total++;
		document.getElementById("droid-total").innerHTML = droidPop.total;
		document.getElementById("scrapper-total").innerHTML = scrapper.total;
		document.getElementById("extractor-total").innerHTML = extractor.total;
		document.getElementById("miner-total").innerHTML = miner.total;
	}
}

//update every field
function updateNumbers(){
	document.getElementById("scrpDrills").innerHTML = scrapDrill.total;
	document.getElementById("gasDrills").innerHTML = gasDrill.total;
	document.getElementById("radDrills").innerHTML = radDrill.total;
	document.getElementById("droidFacts").innerHTML = droidFactory.total;
	document.getElementById("scrapper-total").innerHTML = scrapper.total;
	document.getElementById("extractor-total").innerHTML = extractor.total;
	document.getElementById("miner-total").innerHTML = miner.total;
	document.getElementById("droid-total").innerHTML = droidPop.total;
	document.getElementById("scrap-total").innerHTML = Math.round(scrap.total);
	document.getElementById("gas-total").innerHTML = Math.round(gas.total);
	document.getElementById("radioactive-total").innerHTML = Math.round(radioactive.total);

}

function updateBars(){
  var progress = document.getElementById("progress");
  var height = scrap.total * 0.01;
  progress.style.height = height + '%';

}

/*
function updateBars(){
  var progress = document.getElementById("progress");
  var width = (score / goalScore) * 100;
  var progressint = progress.style.width.replace('%', '');
	if(progressint < 100){
		progress.style.width = width + '%';
	}
}
*/

/*
function saveGame(){
  var save = {
    scrap: scrap,
    gas: gas,
    radioactive: radioactive
  };
  localStorage.setItem("save", JSON.stringify(save));
}

function loadGame(){
  var save = JSON.parse(localStorage.getItem("save"));
  if(save !== null){
    if(typeof save.score !== "undefined"){
      score = save.score;
    }
    if(typeof save.autoClickers !== "undefined"){
      autoClickers = save.autoClickers;
    }
    if(typeof save.autoClickerCost !== "undefined"){
      autoClickerCost = save.autoClickerCost;
    }
  }
  updateNumbers();
}
*/
