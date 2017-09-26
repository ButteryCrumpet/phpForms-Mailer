$('document').ready(function(){
  $('.ppTParent').autoToggle();
});

(function($){

  $.fn.autoToggle = function(settings) {
    const toggleHandler = new ToggleHandler(this, settings);
  }

  function ToggleHandler(elements, settings) {
    const _ = this;

    _.togglers = [];

    elements.each(function(i) {
      var toggler = new Toggler(this, settings);
      _.togglers.push(toggler);
      if (i != 0) toggler.hideChildren();
      $(this).click({index: i, handler: _}, _.toggles);
    })
  }

  ToggleHandler.prototype.toggles = function(event) {
    const _ = event.data.handler; //bad scoping, this = element, needs new this

    var index = event.data.index;

    _.togglers[index].showChildren();

    for (var i = 0; i < _.togglers.length; i++) {
      var toggler = _.togglers[i];
      if (toggler.type = 'linked' && index != i) {
        toggler.hideChildren();
      }
    }
  }

  function Toggler(element, settings) {
    const _ = this;

    _.element = element;
    _.tag = "pptoggle";
    _.childClass = ".ppTChild";
    _.type = 'linked';

    _.children = [];
    _.name = $(element).data(_.tag);
    _.active = false;

    _.getDependents();
  }

  Toggler.prototype.getDependents = function() {
    const _ = this;

    $(_.childClass).each(function(){
      if ($(this).data(_.tag) == _.name) {
        _.children.push(this);
      }
    })
  }

  Toggler.prototype.showChildren = function() {
    const _ = this;

    _.active = true;
    for (let i = 0; i < _.children.length; i++) {
      $(_.children[i]).show();
    }
  }

  Toggler.prototype.hideChildren = function() {
    const _ = this;
    
    _.active = false;
    for (let i = 0; i < _.children.length; i++) {
      $(_.children[i]).hide();
    }
  }

})(jQuery);