var xhr = createRequest();
var selectedTeam = null;
var activeCompetition = null;
var startTime = null;
var chartData = {
    labels: ["", "", "", "", ""],
    datasets: [{
      label: "Points",
      backgroundColor: 'green',
      data: [0, 0, 0, 0, 0],
    }]
};

window.onload = function() {
  createChart();
  document.getElementById('myChart').style.display = "none";
  document.getElementById('leaderboard-table').style.display = "none";
  getData();
  document.getElementById('myChart').style.display = "inline";
  if (selectedTeam == ""){
    var output = "<h3>NO TEAM SELECTED</h3>You can select a team to track their live stats.<br><a href=\"search.php\">Click here to select a team</a>";
    document.getElementById('myTeam').innerHTML = output;
  }
  timer();
  // Set chart button to hide table and display chart
  document.getElementById('chartButton').addEventListener('click', function() {
    displayChart();
  })
  // On table click, chart button should hide table and display chart
  document.getElementById('tableButton').addEventListener('click', function() {
    displayTable();
  })
};

window.setInterval(getData, 2000);

function getData(){
  if (xhr){
    var url = "getLeaderboardData.php?activeCompetition=" + activeCompetition + "&selectedTeam=" + selectedTeam;
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200){
        var result = JSON.parse(this.responseText);
        var newLabels = result[0];
        var newData = result[1];
        var topTeam = result[2];
        var selectedTeam = result[3];
        chartData.datasets[0].data = newData;
        chartData.labels = newLabels;
        if (selectedTeam != ""){
          updateTeamStats(selectedTeam, "myTeam");
        }
        updateTeamStats(topTeam, "topTeam");
        updateTable(newLabels, newData);
        window.myChart.update();
      }
    }
    xhr.open("GET", url, true);
    xhr.send(null);
  }
}

function updateTeamStats(team, divID){
  var output = "<h3>" + team[0] + "</h3>";
  output += team[1] + " POINTS<br>";
  output += "QUESTION: " + team[2];
  output += "<table align=\"center\" style=\"width:50%\">";
  output += "<tr><th>Correct</th><th>Pass</th></tr>";
  output += "<tr><td>" + team[3] + "</td>";
  output += "<td>" + team[4] + "</td></tr></table>"
  document.getElementById(divID).innerHTML = output;
}

function updateTable(newLabels, newData){
  var output = "<tr><th>Team Initials</th><th>Score</th></tr>";
  for (i = 0; i < 5; i++){
    output += "<tr><td>" + newLabels[i] + "</td>";
    output += "<td>" + newData[i] + "</td></tr>";
  }
  document.getElementById("leaderboard-table").innerHTML = output;
}

function createChart(){
  var canvas = document.getElementById('myChart').getContext('2d');
  window.myChart = new Chart(canvas,{
    type: 'horizontalBar',
    data: chartData,
    options: {
      elements: {
        rectangle: {
          borderWidth: 2,
        }
      },
      responsive: true,
      legend: {
        position: 'bottom'
      },
      scales: {
        xAxes: [{
          ticks: {
            beginAtZero:true
          }
        }]
      }
    }
  });
}

function timer(){
  var timeValues = startTime.split(":");
  var countDownDate = new Date();
  countDownDate.setHours(timeValues[0] + 1);
  countDownDate.setMinutes(timeValues[1]);
  countDownDate.setSeconds(timeValues[2].split(".")[0]);
  // Update the count down every 1 second
  window.setInterval(function() {
    // Get todays date and time
    var now = new Date().getTime();
    // Find the distance between now and the count down date
    var distance = countDownDate - now;
    // Time calculations for minutes and seconds
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    // Display the result in the element with id="demo"
    document.getElementById("timer").innerHTML = "Time Remaining: " + minutes + "m " + seconds + "s ";
    // If the count down is finished, write some text
    if (distance < 0) {
      clearInterval(window );
      document.getElementById("timer").innerHTML = "Competition has ended.";
    }
  }, 1000);
}

function displayChart(){
  document.getElementById('myChart').style.display = "inline";
  document.getElementById("leaderboard-table").style.display = "none";
}

function displayTable(){
  document.getElementById('myChart').style.display = "none";
  document.getElementById("leaderboard-table").style.display = "inline";
}

function setSelectedTeam(selectedTeam){
  this.selectedTeam = selectedTeam;
}

function setActiveCompetition(activeCompetition){
  this.activeCompetition = activeCompetition;
}

function setStartTime(startTime){
  this.startTime = startTime;
}
