window.onload = function() {
  prepareBrief();
  prepareSlideShow();
};

function prepareBrief() {
  var expand = document.getElementById('expand');
  if (expand.scrollHeight === 20) {
    expand.classList.remove("hidde-brief");
  }
  expand.onclick = function(e) {
    setTimeout(function () {
      expand.classList.add("hidde-brief");
    }, 500);
  };

}

function prepareSlideShow() {
  var buttons = document.getElementsByTagName('button');

  for (var i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('click', function(e) {
      var slider = document.getElementById('slider-show');
      // buttonClasses.remove("close");
      buttons[0].classList.toggle("open");
      buttons[0].classList.toggle("close");
      buttons[1].classList.toggle("open");
      buttons[1].classList.toggle("close");
      slider.classList.toggle("turn");
    });
  }
}
