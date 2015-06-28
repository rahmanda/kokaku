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
@stop