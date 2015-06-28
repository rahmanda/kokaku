/**
 * Module: Statistic
 * Description: Metadata statistic, displayed in sideNav
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - [external module - like open source]
 */
function Statistic() {}

/**
 * Get statistic data
 * @return {void}
 */
Statistic.prototype.getStat = function () {
  var self = this;
  $.ajax({
    url: "http://localhost:8000/metadata/count",
    method: "GET",
    dataType: "json",
    success: function(data) {
      self.drawStatistic(data);
    }
  });
}

/**
 * Draw statistic in sideNav
 * @param  {object} data
 * @return {void}
 */
Statistic.prototype.drawStatistic = function (data) {
  var sideNav = $(".side-nav");
  var uncompleteNav = sideNav.find("ul .go-incomplete");
  var completeNav = sideNav.find("ul .go-complete");
  var allNav = sideNav.find("ul .go-all");

  uncompleteNav.find("span").text(data.uncomplete);
  completeNav.find("span").text(data.complete);
  allNav.find("span").text(data.all);
}

