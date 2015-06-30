@extends("templates.base")

@section("title")
{{ "Login" }}@stop

@section("content")
<div class="form-login">
<h1 class="form-title">Kokaku</h1>
<form action="login" accept-charset="utf-8">
  <div class="input input-username">
    <label for="username">Username</label>
    <input placeholder="your username" name="username" type="text" id="username">
  </div>
  <div class="input input-password">
    <label for="password">Password</label>
    <input name="password" type="password" value id="password">
  </div>
  <div class="input input-submit">
    <input type="submit" value="Login">
  </div>
  <div class="link-register"><p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p></div>
</form>
</div>
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