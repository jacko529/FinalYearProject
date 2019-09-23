@extends('BaseTemplates.app')

@section('content')




<section data-router-view="home" class="home">
    <div class="containers">
            <form class="form" id="form">
                    <h1>Register</h1>
                    <p>Please fill in this form to create an account.</p>

                    <label for="first-name"><b>Forname</b></label>
                    <input type="text" id="first-name" class="form-input" placeholder="Enter forname" name="first-name" required>

                    <label for="surname"><b>Surname</b></label>
                    <input type="text" id="surname" class="form-input" placeholder="Enter Email" name="surname" required>

                    <label for="email"><b>Email</b></label>
                    <input type="text" id="email" class="form-input" placeholder="Enter Email" name="email" required>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" id="password" class="form-input" placeholder="Enter Password" name="psw" required>

                    <label for="psw-repeat"><b>Repeat Password</b></label>
                    <input type="password" id="password-repeat" class="form-input" placeholder="Repeat Password" name="psw-repeat" required>

                    <button type="submit" id="registration" class="auth-button">Register</button>

                <div class="signin">
                    <p>Already have an account? <a href="#">Sign in</a>.</p>
                </div>
            </form>
    </div>
</section>
@endsection
