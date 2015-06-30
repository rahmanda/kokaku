/**
 * Module: Auth
 * Description: authentication
 * Dependencies:
 *   local:
 *     - Flash
 *   external:
 *     - jQuery
 *     - js.cookie
 */
function Auth() {
  // current scope
  var self = this;

  // properties 
  self.tokenKey = 'tknkk';
  self.flash = new Flash();
  self.nanobar = new Nanobar({
    id: "nanobar"
  });

  // jQuery DOM
  self.registerButton = $("#btn-register");
  self.loginButton = $(".input-submit input");

  // event handler
  self.registerButton.on("click", function(e) {
    e.preventDefault();

    self.register();
  });

  self.loginButton.on("click", function(e) {
    e.preventDefault();

    self.login();
  });
}

/**
 * Login to system
 * @param  {string} username
 * @param  {string} password
 * @return {void}         
 */
Auth.prototype.login = function() {

  var self = this;

  if(self.isAuthenticate()) {

    self.redirectTo("app");

  } else {

    var credentials = self.getLoginData();

    $.ajax({
      url: "http://matome.local/api/users/login",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(credentials),
      success: function(response) {
        self.nanobar.go(100);
        self.saveToken(response.token);
        self.redirectTo("app");
      },
      progress: function() {
        self.nanobar.go(50);
      },
      error: function(jqXHR) {
        var message = jqXHR.responseJSON.message; 
        self.nanobar.go(100);
        self.flash.show("error", message);
      }
    });
  }

}

/**
 * Redirect to desire option
 * @param  {string} opt
 * @return {void}    
 */
Auth.prototype.redirectTo = function(opt) {
  if(opt == "app") {
    window.location.href = "http://localhost:8001/metadata?view=incomplete&orderBy=created_at&order=desc&page=1";
  } else if(opt == "login") {
    window.location.href = "http://localhost:8001/login";
  }
}

/**
 * Attempt register
 * @return {void}
 */
Auth.prototype.register = function() {
  var self = this;

  if(self.isAuthenticate()) {

    self.redirectTo("app");

  } else {

    var credentials = self.getRegisterData();

    $.ajax({
      url: "http://matome.local/api/users",
      method: "POST",
      contentType: "application/json",
      data: JSON.stringify(credentials),
      success: function(response) {
        self.nanobar.go(100);
        console.log(response);
        self.flash.show("success", "You have successfully been registered. Please <a href='http://localhost:8001/login'>login</a> to continue.");
      },
      progress: function() {
        self.nanobar.go(50);
      },
      error: function(jqXHR) {
        var message = jqXHR.responseJSON.message; 
        self.nanobar.go(100);
        self.flash.show("error", message.join(" "));
      }
    });

}

}

/**
 * Get login data form
 * @return {object}
 */
Auth.prototype.getLoginData = function() {
  return {
    username: $(".input-username input").val(),
    password: $(".input-password input").val()
  }
}

Auth.prototype.getRegisterData = function() {
  return {
    email: $("#email").val(),
    username: $("#username").val(),
    password: $("#password").val(),
    password_confirmation: $("#validate_password").val()
  }
}

/**
 * Logout user
 * @return {void}
 */
Auth.prototype.logout = function() {

  Cookies.remove(this.tokenKey);
  this.redirectTo("login");

}

/**
 * Save token
 * @param  {string} token
 * @return {void}      
 */
Auth.prototype.saveToken = function(token) {

  Cookies.set(this.tokenKey, token, { expires: 7 });

}

/**
 * Get token
 * @return {v} [description]
 */
Auth.prototype.getToken = function() {
  
  return Cookies.get(this.tokenKey);

}

/**
 * Check if user is authenticate
 * @return {Boolean}
 */
Auth.prototype.isAuthenticate = function() {

  if(this.getToken()) {
    return true;
  } else {
    return false;
  }

}