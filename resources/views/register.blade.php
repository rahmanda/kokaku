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
  <div class="input input-submit">
    <input type="submit" value="Register">
  </div>
</form>
</div>
@stop