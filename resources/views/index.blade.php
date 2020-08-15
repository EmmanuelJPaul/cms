@extends('layouts.layout')


@section('content')


<!-- Content Starts Here -->

<style>
    .login_form_wrapper{
        background-color: #fff;
        padding: 40px;
        width: 400px;
        border-radius: 5px;
        margin-left: auto;
        margin-right: auto;
    }
    .form_base{
        text-align: center;
    }
    h2,label,a{
        color: #707070;
    }
    a,label{
        font-style: italic;
    }
</style>

<div class="ui centered grid">
    <!-- <div class="ten wide computer column" style="background-color: #F5F5F5;"></div> -->
    <div class="six wide computer column">
       
        <div class="login_form_wrapper">
            <h2>Login to your account</h2>
            @error('email')
                <!-- Credential Validation -->
                <div class="ui error message" style="width: 320px;">
                    <i class="close icon"></i>
                        {{ $message }}
                </div>
            @enderror
            <div class="ui form">
                <div class="ui error message"></div>
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="field">
                        <label>Email ID:</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <div class="field">
                        <label>Password:</label>
                        <input type="password" id="password" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                    </div>
                    <div class="ui two column grid">
                        <div class="column">
                            <div class="ui checkbox">
                                <input type="checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label>Remember me</label>
                            </div>
                        </div>
                        <div class="right aligned column">
                            <a  href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                    </div>
                    <div class="field"><br />
                        <button class="fluid ui teal button" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="form_base">
            <p>Need an account? <a  href="{{ route('register') }}">Register here</a></p>
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
    on: 'blur',
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
