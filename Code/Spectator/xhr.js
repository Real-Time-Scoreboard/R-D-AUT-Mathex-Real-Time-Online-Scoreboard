/**
	This file contains a createRequest method which returns an xhr object.
  An xhr object is an XMLHttpRequest. Used for Ajax.
  This file is included in leaderboard.php and used leaderboard.js
**/
function createRequest() {
    var xhr = false;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
}
