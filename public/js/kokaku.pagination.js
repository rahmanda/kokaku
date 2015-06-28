/**
 * Module: Pagination
 * Description: Generate pagination ui
 * Dependencies:
 *   local:
 *   external:
 *     - jQuery
 *     - Mustache.js
 */
function Pagination() {
  // properties
  this.paramUrl = {
    view : $(document).getUrlParam('view'),
    orderBy : $(document).getUrlParam('orderBy'),
    order : $(document).getUrlParam('order')
  };

  this.currentUrl = this.generateUrl(this.paramUrl);

  // jQuery DOM
  this.pagination = $(".pagination");
  this.template = $("#template-pagination");
}

/**
 * Generate url
 * @param  {string} view   
 * @param  {string} orderBy
 * @param  {string} order  
 * @return {string}        
 */
Pagination.prototype.generateUrl = function (param) {

  return 'http://'+window.location.host+""+window.location.pathname+"?"+$.param(param);

}

/**
 * Draw pagination DOM
 * @param  {object} data
 * @return {void}     
 */
Pagination.prototype.draw = function (data) {

  var currentPage = data.current_page;
  var nextPage = currentPage + 1;
  var previousPage = currentPage - 1;
  var param = this.paramUrl;

  if(data.next_page_url) {
    param.page = nextPage; 
    data.next_page_url = this.generateUrl(param);
  }

  if(data.prev_page_url) {
    param.page = previousPage; 
    data.prev_page_url = this.generateUrl(param);
  }  

  if(data.current_page == 1) {
    data.first_page_url = null;
  } else {
    param.page = 1;
    data.first_page_url = this.generateUrl(param);
  } 

  if(data.last_page == 0) {
    data.last_page_url = null;  
  } else {
    param.page = data.last_page;
    data.last_page_url = this.generateUrl(param);
  } 

  var template = this.template.html();
  Mustache.parse(template);
  this.pagination.html(Mustache.render(template, data));
   
}