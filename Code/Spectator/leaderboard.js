/*
This file is used to run the AJAX operations for the leaderboard.php page.
It queries the database for updates on the activeCompetition and displays the
data on the page. Works alongside xhr.js, chartjs, and getLeaderboardData.php.
*/

// Initialise the xhr object.
var xhr = createRequest();
// Initialise global variables to null.
var selectedTeam = null;
var activeCompetition = null;
var startTime = null;
// Initialise empty chart data. This is used by chartjs.
var chartData = {
    labels: ["", "", "", "", ""],
    datasets: [{
      label: "Points",
      backgroundColor: 'green',
      data: [0, 0, 0, 0, 0],
    }]
};

/*
This method runs when the page has loaded.
It creates the chart object, displays appropriate text for the selected team,
starts the timer, and adds listeners for the change view buttons.
*/
window.onload = function() {
  createChart();
  // Hide the chart and the table.
  document.getElementById('myChart').style.display = "none";
  document.getElementById('leaderboard-table').style.display = "none";
  // Get data for leaderboard page.
  getData();
  // Now show the chart.
  document.getElementById('myChart').style.display = "inline";
  // If the selectedTeam is empty, show default text message.
  if (selectedTeam == ""){
    var output = "<h3>NO TEAM SELECTED</h3>You can select a team to track their live stats.<br><a href=\"search.php\">Click here to select a team</a>";
    document.getElementById('myTeam').innerHTML = output;
  }
  // Start the timer
  timer();
  // Set chart button to hide table and display chart
  document.getElementById('chartButton').addEventListener('click', function() {
    displayChart();
  })
  // Set table button to hide chart and display table.
  document.getElementById('tableButton').addEventListener('click', function() {
    displayTable();
  })
};

// This method calls the getData function every 2 seconds.
// This is what updates the page with new data.
window.setInterval(getData, 2000);

/*
Gets the data from the database and displays it on the leaderboard.php page.
Uses Ajax to get the data.
This method is called every 2 seconds (refer to window.setInterval).
*/
function getData(){
  // If the xhr object is initialised.
  if (xhr){
    // url for the Ajax query. Parameters activeCompetition and selectedTeam are
    // passed along. It doesn't matter if selectedTeam is empty.
    var url = "getLeaderboardData.php?activeCompetition=" + activeCompetition + "&selectedTeam=" + selectedTeam;
    // When the Ajax query successfully returns, get the data and pass it to the
    // appropriate methods.
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200){
        // Get the responseText from the php file.
        // The responseText in this case is an array which contains 4 arrays.
        // result[0] = The top 5 team names in descending order of score.
        // result[1] = The top 5 team scores in descending order of score.
        // result[2] = Stats for the top team.
        // result[3] = Stats for the selected team.
        var result = JSON.parse(this.responseText);
        var newLabels = result[0];
        var newData = result[1];
        var topTeam = result[2];
        var selectedTeam = result[3];
        // Set the new scores and labels for the chart.
        chartData.datasets[0].data = newData;
        chartData.labels = newLabels;
        // If selectedTeam isn't empty, update using new data.
        if (selectedTeam != ""){
          updateTeamStats(selectedTeam, "myTeam");
        }
        // Update the top team data.
        updateTeamStats(topTeam, "topTeam");
        // Update the table with the new data.
        updateTable(newLabels, newData);
        // Refresh the chartjs object.
        window.myChart.update();
      }
    }
    // Open and send the ajax request.
    xhr.open("GET", url, true);
    xhr.send(null);
  }
}

/*
Generates an output string and inserts it into the div element for the
particular team.
Used to update the top and selected teams.
*/
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

/*
Generates an output string and inserts it into the table element for
the leaderboard. Contains the team initials and their scores for the top 5 teams
in the competition.
*/
function updateTable(newLabels, newData){
  var output = "<tr><th>Team Initials</th><th>Score</th></tr>";
  for (i = 0; i < 5; i++){
    output += "<tr><td>" + newLabels[i] + "</td>";
    output += "<td>" + newData[i] + "</td></tr>";
  }
  document.getElementById("leaderboard-table").innerHTML = output;
}

/*
Function to initialise the chartjs object.
Follows the existing functions inside the chartjs api.
*/
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

/*
Timer for the competition. Uses the startTime of the competition to calculate
how long the competition will go for and shows that on the leaderboard.php page.
Updates every second.
*/
function timer(){
  // The timestamp retrieved from the pgsql database is in the following format:
  // HH:MM:SS.mmmm
  // Where HH = hours, MM = minutes, SS = seconds, and mmmm = miliseconds.
  // Using split, the timeValues are split into an array.
  var timeValues = startTime.split(":");
  // Create a new Date object.
  var countDownDate = new Date();
  // Add 0.5 to start time (competitions last for 30 minutes). Set for date.
  countDownDate.setHours(timeValues[0] + 0.5);
  // Set the minutes for the date.
  countDownDate.setMinutes(timeValues[1]);
  // Split the miliseconds from the seconds. Then set the seconds for the date.
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
    // Display the result in the element with id="timer"
    document.getElementById("timer").innerHTML = "Time Remaining: " + minutes + "m " + seconds + "s";
    // If the count down is finished, output a message. Stop the updates.
    if (distance < 0) {
      clearInterval(window);
      document.getElementById("timer").innerHTML = "Competition has ended.";
    }
  }, 1000);
}

/*
Function called when user clicks the chart button.
Hides the chart and displays the table.
*/
function displayChart(){
  document.getElementById('myChart').style.display = "inline";
  document.getElementById("leaderboard-table").style.display = "none";
}

/*
Function called when user clicks the chart button.
Hides the chart and displays the table.
*/
function displayTable(){
  document.getElementById('myChart').style.display = "none";
  document.getElementById("leaderboard-table").style.display = "inline";
}

// Setter for the selected team.
function setSelectedTeam(selectedTeam){
  this.selectedTeam = selectedTeam;
}

// Setter for active competition
function setActiveCompetition(activeCompetition){
  this.activeCompetition = activeCompetition;
}

// Setter for start time
function setStartTime(startTime){
  this.startTime = startTime;
}
