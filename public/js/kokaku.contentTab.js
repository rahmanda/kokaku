/**
 * Module: ContentTab
 * Description: Event handler for content tabs
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - jquery.geturlparam.js
 */

function ContentTab() {
  // current scope
  var self = this;

  // jQuery DOM
  self.container = $(".items-wrap .add-form");

  self.tab = {
    content: $(".add-form .group-input"),
    button: $(".act-tabs .tab")
  };

  self.tabMain = {
    content: self.container.children(".group-1"),
    button: $(".tab-main"),
    link: "?tab=1"
  };

  self.tabOptional = {
    content: self.container.children(".group-2"),
    button: $(".tab-optional"),
    link: "?tab=2"
  };

  self.tabFile = {
    content: self.container.children(".group-3"),
    button: $(".tab-file"),
    link: "?tab=3"
  }; 

  // initial function
  self.init();

  // event handler
  self.tab.button.on("click", function(e) {
    self.switchTab($(this), self);
  });
}

/**
 * Initial function / go to current tab
 * @return {void}
 */
ContentTab.prototype.init = function() {
  this.switchTab(this.getCurrentTab(), this);
}

/**
 * Get current tab based on url query parameter 'tab'
 * @return {jQuery DOM} tab button
 */
ContentTab.prototype.getCurrentTab = function() {
  var currentTab = $(document).getUrlParam("tab");
  if(currentTab === "1") {
    return this.tabMain.button;
  } else if(currentTab === "2") {
    return this.tabOptional.button;
  } else {
    return this.tabFile.button;
  }
}

/**
 * Show desired tab
 * @param  {jQuery DOM} tab
 * @return {void}
 */
ContentTab.prototype.show = function(tab) {
  tab.content.addClass("show");
  tab.button.addClass("active");
  window.history.pushState(null, null, tab.link);
}

/**
 * Reset tab
 * @return {void}
 */
ContentTab.prototype.reset = function() {
  this.tab.content.removeClass("show");
  this.tab.button.removeClass("active");
}

/**
 * Switch to tab
 * @param  {jquery DOM} target  clicked tab button 
 * @param  {scope} parentScope 
 * @return {void}
 */
ContentTab.prototype.switchTab = function(target, parentScope) {
  var tab;
  if(target.hasClass("tab-main")) {
    tab = parentScope.tabMain;
  } else if(target.hasClass("tab-optional")) {
    tab = parentScope.tabOptional;
  } else {
    tab = parentScope.tabFile; 
  }
  parentScope.reset();
  parentScope.show(tab);
}