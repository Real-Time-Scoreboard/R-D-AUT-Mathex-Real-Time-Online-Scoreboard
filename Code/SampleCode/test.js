$(document).ready(function(){

    $("button").click(function(){

        $("#box").load("Marker.html");

    });

});

<!--
$(document).ready(function() {

  $("#me").on('click', 'a', function(e) { //step 1
    e.preventDefault(); //prevent default action, step2
    var url = $(this).attr('href'); //get the url, step 2

    $.ajax({ //step 3
      type: 'GET',
      url: url,
      //your other options
      success: function(response) { //on success
        $("#test").html(response); //update your div, step 4
      }
    });
  });
});

function addTab() {
  var link = document.createElement('a');
  link.textContent = 'Link Title';
  link.className = 'nav-item';
  link.className = 'nav-link';
  link.href = '../WebDevelopment/assign2_1.0/admin.html';
  var li = document.createElement('li');
  li.appendChild(link);
  document.getElementById('my_menu').appendChild(li);
}

function sendRequestDropBoxContentUsingJS() {
  var xhr = createRequest(); // get XMLHttpRequest object
  xhr.open("POST", "PhpFiles/markerManager.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) { // response is success
      var data = xhr.responseText; // print message to the allocate part
      setDropBox("selectTeam", data.split(","));
    } // end if
  } // end anonymous call-back function
  xhr.send(); // send request to php file
}
