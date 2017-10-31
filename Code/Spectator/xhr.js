/**
	File: xhr.js
	Author: Karanjit Gahunia
	Student ID: 14869048
	
	This file contains a createRequest 
	method which returns an xhr object.
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
