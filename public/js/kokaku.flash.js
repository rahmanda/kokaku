/**
 * Module: Flash
 * Description: flash message handling
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - [external module - like open source]
 */
function Flash() {
  // current scope
  var self = this;

  // properties
  this.timeout = 5000;
  this.message = {
    success: "Your files has successfully been uploaded. Complete the metadata.",
    error: "Your files cannot be uploaded. Contact your admin to solve this issue."
  };
  this.flashType = {
    success: "success",
    error: "error"
  };

  // jQuery DOM
  this.container = $(".flash");
  this.message = $(".flash .message");
  this.closeBtn = $(".flash .btn-close");

  // event handler
  this.closeBtn.on("click", $.proxy(this.hide, this));
}

/**
 * Show flash message
 * @param  {string} type    
 * @param  {string} message 
 * @return {void}
 */
Flash.prototype.show = function(type, message) {
  var self = this;
  var message = message || null;

  self.container.addClass(type);
  self.container.addClass("show");

  if(type == self.flashType.error) {
    self.message.html((message ? message : self.message.error));
    self.container.removeClass("success");
  } else {
    self.message.html((message ? message : self.message.success));
    self.container.removeClass("error");
  }

  setTimeout(function() {
    self.hide();
  }, self.timeout);
}

/**
 * Hide flash message
 * @return {void}
 */
Flash.prototype.hide = function() {
  this.container.removeClass("show");
}