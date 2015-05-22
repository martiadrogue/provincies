window.onload = function() {
  prepareSearch();
};

function prepareSearch() {
  var searchBox = document.getElementById('search-box');
  searchBox.addEventListener('keypress', function(e) {
    var theEvent = e || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;

    if(e.keyCode == 13) { // enter
      alert('get Search!');
      return true;
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
  searchBox.focus();
}
