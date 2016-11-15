var score = 0;
var autoClickers = 0;
var autoClickerCost = 5;
var goalScore = 1000000;

window.onload = loadGame;
window.onbeforeunload = saveGame;

function scoreUp(amount){
  score += amount;
  document.getElementById("score").innerHTML = Math.round(score);
}

function buyAutoClicker(){
  if(score >= autoClickerCost){
    autoClickers++;
    score -= autoClickerCost;
    autoClickerCost *= 1.5;
    updateNumbers();
}

}

function updateBars(){
  var progress = document.getElementById("progress");
  var width = (score / goalScore) * 100;

  progress.style.width = width + '%';
}

window.setInterval(function(){
  scoreUp(autoClickers);
  updateBars();
}, 1000);

function saveGame(){
  var save = {
    score: score,
    autoClickers: autoClickers,
    autoClickerCost: autoClickerCost
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
      autoClickerCost = save.autoClickers;
    }
  }
  updateNumbers();
}

function updateNumbers(){
  document.getElementById("autoClickerCost").innerHTML = Math.round(autoClickerCost);
  document.getElementById("score").innerHTML = Math.round(score);
  document.getElementById("nrOfAutoClickers").innerHTML = Math.round(autoClickers);
}
