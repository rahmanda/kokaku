/**
 * Module: [module name]
 * Description: [description]
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - [external module - like open source]
 */
function NavContent () {
  // current scope
  var self = this;

  // properties
  this.utils = new Utils();
  this.urlParam = {
    orderBy: $(document).getUrlParam('orderBy'),
    order: $(document).getUrlParam('order'),
    view: $(document).getUrlParam('view')
  };

  // jQuery DOM
  this.nav = $(".nav-content span[class^='act'] p");
  this.options = $("#sort-options li");

  // event handler
  this.nav.on('click', this.toggleMenu);
  this.options.on('click', function() {
    self.toggleOption(this, self);
  });

  // initial function
  this.init();
}

/**
 * Initial function
 * @return {void}
 */
NavContent.prototype.init = function() {
  this.setOption(this.urlParam.orderBy, this.urlParam.order);
}

/**
 * Toggle menu
 * @return {void}
 */
NavContent.prototype.toggleMenu = function () {
  var el = $(this);
  el.children().toggleClass("fa-angle-down");
  el.children().toggleClass("fa-angle-up");
  el.next().toggleClass("show");
};

/**
 * Reset menu
 * @return {void}
 */
NavContent.prototype.reset = function() {
  this.options.removeClass("active");
  this.nav.next().removeClass("show");
}

/**
 * Toggle option
 * @param  {scope} parent
 * @param  {scope} self  
 * @return {void}       
 */
NavContent.prototype.toggleOption = function (parent, self) {
  self.reset(); 
  var el = $(parent);
  el.addClass("active");

  var orderBy = el.attr("data-type");
  var order = el.attr("data-order");
  var param = $.param({ view: self.urlParam.view, orderBy: orderBy, order: order });
  window.location.href = 'http://'+window.location.host+""+window.location.pathname+"?"+param;
};

/**
 * Set option
 * @param {string} orderBy
 * @param {string} order  
 */
NavContent.prototype.setOption = function(orderBy, order) {
  this.options.removeClass("active");
  $("#sort-options ."+orderBy+"-"+order).addClass("active");
}