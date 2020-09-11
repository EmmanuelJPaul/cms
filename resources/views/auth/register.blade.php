@extends('layouts.layout')

@section('content')

<div class="v-center">
    <div class="ui centered grid">
        <div class="six wide computer column">
            
            <div class="form_wrapper">
                <h2>Create a new account</h2>          
                <form class="ui form" method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="field">
                        <label>Name:</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    <div class="field">
                        <label>Email ID:</label>
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    <div class="field">
                        <label>Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="field">
                        <label>Confirm Password:</label>
                        <input type="password" id="password-confirm" name="password_confirmation" required>
                    </div>
                    <div class="field"><br />
                        <button class="fluid ui blue button" type="submit">Register</button>
                    </div>
                </form>
            </div>
            <div class="form_base">
                <p>Already have an account? <a  href="{{ url('/') }}">Login here</a></p>
            </div>
        </div>
    </div>
</div>
<script>
$('.ui.form')
  .form({
    inline: true,
    fields: {
        name: {
            identifier  : 'name',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter your name'
                }
            ]
        },
        email: {
            identifier  : 'email',
            rules: [
                {
                    type   : 'email',
                    prompt : 'Please enter a valid email'
                }
            ]
        },
        password: {
            identifier  : 'password',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please enter a password'
                },
                {
                    type: 'minLength[8]',
                    prompt: 'Password must be 8 characters long'
                }
            ]
        },
        password_confirmation: {
            identifier  : 'password_confirmation',
            rules: [
                {
                    type   : 'empty',
                    prompt : 'Please re-enter the password'
                },
                {
                    type: 'match[password]',
                    prompt: 'The passwords do not match'
                }
            ]
        }
    }
  })
;
</script>
@endsection
