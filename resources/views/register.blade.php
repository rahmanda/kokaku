@extends("templates.base")

@section("title")
{{ "Register - Kokaku" }}@stop

@section("content")
<div class="form-register">
<h1 class="form-title">Register</h1>
<form action="register" accept-charset="utf-8">
  <div class="input input-email">
    <label for="email">Email Address</label>
    <input placeholder="your@email.com" name="email" type="text" id="email">
  </div>
  <div class="input input-username">
    <label for="username">Username</label>
    <input placeholder="yourusername" name="username" type="text" id="username">
  </div>
  <div class="input input-password">
    <label for="password">Password</label>
    <input placeholder="Minimum 5 characters" name="password" type="password" id="password">
  </div>
  <div class="input input-validate-password">
    <label for="validate_password">Validate password</label>
    <input placeholder="Type again your password" name="validate_password" type="password" id="validate_password">
  </div>
  <div class="input input-register">
    <input type="submit" value="Register" id="btn-register">
  </div>
</form>
</div>
<div id="nanobar"></div>
@include("templates.partials.flash")
@include("templates.partials.tutorialmodal")
@include("templates.partials.settingmodal")
@stop

@section("scripts")
<script src="/vendor/jquery.geturlparam/jquery.geturlparam.min.js"></script>
<script src="/vendor/jquery-ajax-progress/js/jquery.ajax-progress.js"></script>
<script src="/vendor/nanobar/nanobar.min.js" type="text/javascript"></script>
<script src="/vendor/js-cookie/src/js.cookie.js" type="text/javascript"></script>
<script src="/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
<script src="/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="/vendor/jQuery-File-Upload/js/jquery.fileupload.js" type="text/javascript"></script>
<script src="/vendor/mustache.js/mustache.js" type="text/javascript"></script>
<script src="/vendor/momentjs/moment.js" type="text/javascript"></script>
@include("templates.partials.mustache")
<script src="/js/kokaku.min.js"></script>
<script type="text/javascript">
  $(function() {
    var auth = new Auth();
    if(auth.isAuthenticated) {
      auth.redirectTo("app");
    }
  });
</script>
@stop