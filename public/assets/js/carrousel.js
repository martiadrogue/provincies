(function(wdw, undefined) {
  function cssProperty(node, property) {
    return wdw.getComputedStyle(node)[property];
  }

  function width(node) {
    return Number(cssProperty(node, 'width').replace('px', ''));
  }

  function left(node) {
    return Number(cssProperty(node, 'left').replace('px', ''));
  }

  wdw.nodeWidth = width;
  wdw.nodeLeft = left;
})(window);

(function(wdw, doc, undefined) {
  function toArray(arrayLike) {
    return Array.prototype.slice.call(arrayLike);
  }

  function queryAll(selector, context) {
    context = context || doc;
    var nodes = toArray(context.querySelectorAll(selector));
    return nodes.length === 1 ? nodes[0] : nodes;
  }

  wdw.$ = queryAll;
})(window, window.document);

(function(wdw, doc, undefined) {
  function Roller(node) {
    this.container = node;
    this.roller = $('.widget-roller', node);
    this.controls = $('.widget-controller', node);
    this.items = $('.widget-item', node);
    this.start();
    return this;
  }

  Roller.prototype.start = function start() {
    var self = this;
    this.controls.addEventListener('mouseover', function initRoller() {
      self.init();
      self.controls.removeEventListener('mouseover', initRoller);
    });
    this.setWidth();
    return this;
  };
  Roller.prototype.init = function init() {
    this
      .setWalk()
      .setControls()
      .setAnimation();
    return this;
  };
  Roller.prototype.setWidth = function setWidth() {
    var width = this.items.map(nodeWidth).reduce(function(acc, cur) {
      return acc + cur;
    });
    this.roller.style.width = width + 'px';
    return this;
  };
  Roller.prototype.setWalk = function setWalk() {
    var count = this.items.length;
    var walk = nodeWidth(this.items[0]);
    this.walker = {
      walk: walk,
      firstWalk: walk,
      lastWalk: walk / (count % 2 ? 1 : 2),
      steps: Math.floor((count - 1) / 2) - (count % 2 ? 1 : 0),
      oneStep: Math.floor((count - 1) / 2) - (count % 2 ? 1 : 0) === 1,
      walking: false
    };
    this.container.setAttribute('data-max-step', this.walker.steps);
    this.container.setAttribute('data-cur-step', 0);
    return this;
  };
  Roller.prototype.setControls = function setControls() {
    var self = this;
    var PREV = 'prev';
    var NEXT = 'next';

    function move(e) {
      if (e.target.nodeName.toLowerCase() !== 'a' || self.walker.walking) {
        return;
      }

      var node = e.target;
      var back = node.getAttribute('data-action') === PREV;
      var curStep = +self.container.getAttribute('data-cur-step');

      if ((back && !curStep) || (!back && curStep === self.walker.steps)) {
        return;
      }

      self.walker.walking = true;

      var direction = back ? 1 : -1;
      var toStep = curStep + direction * -1;
      var position = nodeLeft(self.roller);
      var inLastStep = toStep === self.walker.steps || curStep === self.walker.steps;
      var step = inLastStep && !self.walker.oneStep ? self.walker.lastWalk : self.walker.walk;
      var walk = position + direction * step;

      self.roller.style.left = walk + 'px';
      self.container.setAttribute('data-cur-step', toStep);
    }

    this.controls.addEventListener('click', move);
    return this;
  };
  Roller.prototype.setAnimation = function setAnimation() {
    var self = this;

    function endAnimation(e) {
      self.walker.walking = false;
    }


    this.controls.addEventListener('click', endAnimation);

    return this;
  };

  wdw.Roller = Roller;
})(window, window.document);

(function(wdw, doc, undefined) {
  function Carousel(selector) {
    selector = selector || '.widget-container';
    var nodes = $(selector);
    if (!nodes.hasOwnProperty('length')) {
      this.nodes = [nodes];
    } else {
      this.nodes = nodes;
    }
    this.carousels = this.nodes.map(function(node) {
      return new Roller(node);
    });
  }

  wdw.Carousel = Carousel;
})(window, document);

(function(wdw, doc, undefined) {
  var carousel = new Carousel();
  wdw.carousel = carousel;
})(window, window.document);
