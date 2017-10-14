//this file provides the apropriate method for requests. to communicate with the server
// file xhr.js
 function createRequest() {
    var xhr = false;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) { // this will not work for IE11 as per documentation
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if (navigator.plugins["Contoso.Control"]) {
          xhr = new ActiveXObject("Contoso");
      }
    return xhr;
} // end function createRequest()
