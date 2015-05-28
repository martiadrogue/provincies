var searchBox = document.getElementById('search-box');

window.onload = function() {
  prepareSearch();
};

function prepareSearch() {
  searchBox.addEventListener('keypress', function(e) {
    var theEvent = e || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;

    if(e.keyCode == 13) { // enter
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
      var root = window.location.protocol + '//' + window.location.host;
      window.location = root + "/provincia/" + searchBox.value;
    } else if(e.keyCode == 8) { // backspace
      return true;
    } else if(e.keyCode == 46) { // delete
      return true;
    }

    if( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  });
}
