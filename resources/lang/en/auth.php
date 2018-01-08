<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'login' => [
        'title' => 'Login',
        'logo' => '<b>E</b>-Document',
        'description' => 'Sign in to start your session',
        'forget_link' => 'I forgot my password',
        'register_link' => 'Register a new membership',
        'gotohome' => '&larr; Go to homepage',
        'credentials' => 'These credentials do not match our records.',
        'form' => [
            'username' => 'Username or Email',
            'password' => 'Password',
            'remember' => 'Remember Me',
            'submit' => 'Sign In',
        ],
    ],
    'register' => [
        'title' => 'Register',
        'logo' => '<b>E</b>-Document',
        'description' => 'Register a new membership',
        'membership' => 'I already have a membership',
        'gotohome' => '&larr; Go to homepage',
        'form' => [
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Retype password',
            'terms' => 'I agree to the <a href="">terms</a>',
            'submit' => 'Sign In',
        ],
    ],
    'forgotpassword' => [
        'title' => 'Forgot Password',
        'logo' => '<b>E</b>-Document',
        'description' => 'Reset Password',
        'form' => [
            'email' => 'Email',
            'submit' => 'Send Password Reset Link',
        ],
    ],
    'resetpassword' => [
        'title' => 'Reset Password',
        'logo' => '<b>E</b>-Document',
        'description' => 'Reset Password',
        'form' => [
            'email' => 'E-Mail Address',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
            'submit' => 'Reset Password',
        ],
    ],
];
