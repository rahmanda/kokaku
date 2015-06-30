/**
 * Module: Metadatas
 * Description: Generate metadata DOM
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - jquery.geturlparam.js
 */

function Metadatas() {
  // properties
  this.urls = {
    all: "http://localhost:8001/metadata/fetchAll/",
    complete: "http://localhost:8001/metadata/fetchComplete/",
    incomplete: "http://localhost:8001/metadata/fetchIncomplete/"
  };

  this.pagination = new Pagination();
  
  this.urlParam = {
    orderBy: $(document).getUrlParam('orderBy'),
    order: $(document).getUrlParam('order'),
    page: $(document).getUrlParam('page'),
    view: $(document).getUrlParam('view')
  };

  // jQuery DOM
  this.lists = $(".list-items .lists");
  this.template = $("#template-metadatas");

  // initial function
  this.init();
}

/**
 * Initial function
 * @return {void}
 */
Metadatas.prototype.init = function() {

  this.setUrlParam(this.urlParam.orderBy, this.urlParam.order, this.urlParam.page);
  this.draw(this.urlParam.view);

}

/**
 * Set url param
 * @param {string} orderBy
 * @param {string} order  
 * @param {string} page   
 */
Metadatas.prototype.setUrlParam = function(orderBy, order, page) {

  this.urls.all = this.urls.all + orderBy + "/" + order + "?page=" + page;
  this.urls.complete = this.urls.complete + orderBy + "/" + order + "?page=" + page;
  this.urls.incomplete = this.urls.incomplete + orderBy + "/" + order + "?page=" + page;

}

/**
 * Draw metadata list DOM
 * @param  {string} option
 * @return {void}       
 */
Metadatas.prototype.draw = function(option) {

  var self = this;
  var option = option || "all"; 

  $.ajax({
    url: self.urls[option],
    method: "GET",
    dataType: "json",
    success: function(response) {
      self.generateDOM(response.data, option, self);
      self.pagination.draw(response);
    },
    error: function(e, data) {
      console.log(e);
    }
  });

}

/**
 * Generate DOM for metadata
 * @param  {object} data       
 * @param  {string} option     
 * @param  {scope} parentScope
 * @return {void}            
 */
Metadatas.prototype.generateDOM = function(data, option, parentScope) {

  var template = parentScope.template.html();
  Mustache.parse(template);
  var input = {  
    meta: data,
    formatDate: function() { return function(rawdata, render) { return moment(render(rawdata)).fromNow();  }; }
  };
  parentScope.lists.html(Mustache.render(template, input));

}

/**
 * Date format for mustachejs template
 * @param  {string} date
 * @return {string}        
 */
Metadatas.prototype.mustacheFormatDate = function(date) {
  return moment(date, "YYYYMMDD").fromNow();
}