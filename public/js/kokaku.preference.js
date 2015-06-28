/**
 * Module: Preference
 * Description: Event handler for preference component
 * Dependencies:
 *   local:
 *     - Modal
 *   external:
 *     - jQuery
 *     - [external module - like open source]
 */

function Preference(){
  // current scope
  var self = this;

  // dependencies
  self.modal = new Modal(); 

  // options
  self.options = ["setting", "tutorial", "logout"];

  // jQuery DOM
  self.elAccount = $(".act-account p");
  self.elAccountOptions = $(".act-account #account-options");
  self.elSetting = $(".go-setting");
  self.elTutorial = $(".act-tutorial");
  self.elLogout = $(".act-logout");

  // event handler
  // ! should be more readable than this
  self.elAccount.on("click", function(e) {
    if(self.isActive($(this))) {
      self.deactivate(self.elAccount);
    } else {
      self.activate(self.elAccount);
    }
    self.toggle(self.elAccountOptions);
  });

  self.elSetting.on("click", function(e) {
    self.deactivate(self.elAccount);
    self.toggle(self.elAccountOptions);
    self.modal.show(self.modal.modal.setting); 
  });

  self.elTutorial.on("click", function(e) {
    self.deactivate(self.elAccount);
    self.toggle(self.elAccountOptions);
    self.modal.show(self.modal.modal.tutorial);
  });

  self.elLogout.on("click", function(e) {

  });
}

/**
 * Toggle an element / triggered to toggle show class
 * @param  {jQuery DOM} el 
 * @return {void}    
 */
Preference.prototype.toggle = function(el) {
  el.toggleClass("show");
}

/**
 * Activate an element / triggered to add class 'active'
 * @param  {jquery DOM} el
 * @return {void}   
 */
Preference.prototype.activate = function(el) {
  el.addClass("active");
}

/**
 * Deactivate an element / triggered to remove class 'active'
 * @param  {jquery DOM} el
 * @return {void}   
 */
Preference.prototype.deactivate = function(el) {
  el.removeClass("active");
}

/**
 * Check if an element is active / has class 'active'
 * @param  {jquery DOM}  el
 * @return {Boolean}   
 */
Preference.prototype.isActive = function(el) {
  if(el.hasClass("active")) {
    return true;
  } else {
    return false;
  }
}