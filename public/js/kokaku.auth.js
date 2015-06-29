/**
 * Module: Auth
 * Description: authentication
 * Dependencies:
 *   local:
 *     - [local module]
 *   external:
 *     - jQuery
 *     - js.cookie
 */
function Auth() { 
  this.tokenKey = 'tknkk';
}

/**
 * Login to system
 * @param  {string} username
 * @param  {string} password
 * @return {void}         
 */
Auth.prototype.login = function() {

  var self = this;

  if(!self.isAuthenticate()) {
    window.location.href = "http://localhost:8000/metadata";
  }

  var credentials = self.getLoginData();

  $.ajax({
    url: "http://localhost:8001/users",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify(credentials),
    success: function(response) {
      self.saveToken(response.token);
      window.location.href = "http://localhost:8000/metadata";
    },
    error: function(e, data) {
      console.log(e);
    }
  });

}

/**
 * Get login data form
 * @return {object}
 */
Auth.prototype.getLoginData = function() {
  return {
    username: $(".input .input-username").val(),
    password: $(".input .input-password").val()
  }
}

/**
 * Logout user
 * @return {void}
 */
Auth.prototype.logout = function() {

  Cookies.remove(this.tokenKey);
  window.location.href = "http://localhost:8000/login";

}

/**
 * Save token
 * @param  {string} token
 * @return {void}      
 */
Auth.prototype.saveToken = function(token) {

  Cookies.set(self.tokenKey, token, { path: 'http://loalhost:8000' });

}

/**
 * Get token
 * @return {v} [description]
 */
Auth.prototype.getToken = function() {
  
  return Cookies.get(self.tokenKey);

}

/**
 * Check if user is authenticate
 * @return {Boolean}
 */
Auth.prototype.isAuthenticate = function() {

  if(Cookies.get(self.tokenKey)) {
    return true;
  }

  return false;

}

Auth.prototype.getUserData = function() {

}

Auth.prototype.getPreferenceData = function() {

}