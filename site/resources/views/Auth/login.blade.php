@extends('BaseTemplates.app')

@section('content')

<section data-router-view="about" class="about">
            <form class="form">
                <h1>Login</h1>

                <label for="email"><b>Email</b></label>
                <input type="text" class="form-input" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" class="form-input" placeholder="Enter Password" name="psw" required>

                <label for="remember-me"><b>Remember me</b></label>
                <input type="checkbox" class="form-input checkbox-rememeber" placeholder="Enter Password" name="remember-me" required>

                <button type="submit" class="auth-button">Login</button>
            </form>
</section>
@endsection
