@extends('layouts.layout')


@section('content')
<!-- Content Starts Here -->
<style>
  body{
    background-image: url('images/jit-main.jpg');
    background-size: cover;
  }
  #overlay{
    width: 100%;
    height: 100%;
    z-index: 3;
    background-color: rgba(239, 251, 248,0.95);
    background-size: cover;
  }
</style>
<div id="overlay"></div>
<div class="v-center">
  <div class="ui centered grid">
      <div class="six wide computer column">
          <div class="form_wrapper">
              <h2>Login to your account</h2>
              @error('email')
                  <!-- Credential Validation -->
                  <div class="ui error message" style="width: 320px;">
                      <i class="close icon"></i>
                          {{ $message }}
                  </div>
              @enderror

              <form class="ui form" method="POST" action="{{ route('login') }}" novalidate>
                  @csrf
                  <div class="field">
                      <label>Email ID:</label>
                      <input type="text" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  </div>
                  <div class="field">
                      <label>Password:</label>
                      <input type="password" id="password" name="password" value="{{ old('password') }}" required>
                  </div>
                  <div class="ui two column grid">
                      <div class="column">
                          <div class="ui checkbox">
                              <input type="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                              <label>Remember me</label>
                          </div>
                      </div>
                      <div class="right aligned column">
                          <!-- <a href="{{ route('password.request') }}">Forgot password?</a> -->
                      </div>
                  </div>
                  <div class="field"><br />
                      <button class="fluid ui blue button" type="submit">Login</button>
                  </div>
              </form>
 
          </div>
          <div class="form_base">
              <p>Need an account? <a href="{{ route('register') }}">Register here</a></p>
          </div>
      </div>
  </div>
</div>
<script>
$('.message .close')
  .on('click', function() {
    $(this)
      .closest('.message')
      .transition('fade')
    ;
  })
;
$('.ui .form')
  .form({
    inline: true,
    fields: {
      email: {
        identifier  : 'email',
        rules: [
          {
            type   : 'email',
            prompt : 'Please enter a valid Email ID'
          }
        ]
      },
      empty: {
        identifier  : 'password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Please enter the password'
          }
        ]
      }
    }
  })
;
</script>

@endsection
