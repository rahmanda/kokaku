/**
 * Module: Modal
 * Description: event handler for modal component
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - [external module - like open source]
 */

function Modal() {
  // current scope
  var self = this;

  // jQuery DOM
  self.modal = {
    generic: $(".modal"),
    tutorial: $(".modal-tutorial"),
    setting: $(".modal-setting")
  };
  self.buttonClose = $(".act-modal .btn-close");

  // event handler
  self.buttonClose.on("click", function(e) {
    self.hide(self.modal.generic);
  }); 
}

/**
 * Show component / trigger to add class 'show'
 * @param  {jQuery DOM} el
 * @return {void}   
 */
Modal.prototype.show = function(el) {
  el.addClass("show");
}

/**
 * Hide component / trigger to remove class 'show'
 * @param  {jQuery DOM} el
 * @return {void}   
 */
Modal.prototype.hide = function(el) {
  el.removeClass("show");
}