/**
 * Module: SideNav
 * Description: SideNav handler
 * Dependencies:
 *   local:
 *     - Statistic
 *   external:
 *     - jQuery
 *     - [external module - like open source]
 */
function SideNav() {
  // properties
  this.statistic = new Statistic();
  this.domain = 'http://localhost:8000';
  this.urls = {
    incomplete: this.domain + '/metadata?view=incomplete&orderBy=created_at&order=desc&page=1',
    complete: this.domain + '/metadata?view=complete&orderBy=created_at&order=desc&page=1',
    all: this.domain + '/metadata?view=all&orderBy=created_at&order=desc&page=1'
  }

  // jQuery DOM
  this.sideNav = $(".side-nav");
  this.template = $("#template-sidenav");

  // initial function
  this.init();
}

/**
 * Initial function
 * @return {void}
 */
SideNav.prototype.init = function() {
  this.draw($(document).getUrlParam('view'));
  this.statistic.getStat();
}

/**
 * Draw sideNav DOM
 * @param  {string} urlParam
 * @return {void}         
 */
SideNav.prototype.draw = function(urlParam) {
  var template = this.template.html();
  Mustache.parse(template);

  this.sideNav.append(Mustache.render(template, { urls: this.urls }));
  this.appendActiveClass(urlParam);
}

/**
 * [appendActiveClass description]
 * @param  {string} urlParam
 * @return {void}         
 */
SideNav.prototype.appendActiveClass = function(urlParam) {
  var nav = this.sideNav.children('ul');
  nav.children('li').removeClass('active');

  if(urlParam) {
    nav.children('.go-'+urlParam).addClass('active');
  }
}