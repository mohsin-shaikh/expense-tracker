<?php

return [

    'title' => 'Register',

    'heading' => 'Create your account',

    'buttons' => [

        'submit' => [
            'label' => 'Register',
        ],

    ],

    'fields' => [

        'name' => [
            'label' => 'Full Name',
        ],

        'email' => [
            'label' => 'Email Address',
        ],

        'password' => [
            'label' => 'Password',
        ],

        'passwordConfirmation' => [
            'label' => 'Confirm Password',
        ],

    ],

    'links' => [

        'login' => [
            'label' => 'Already have an account?',
        ],

    ],

    'messages' => [
        'failed' => 'These credentials do not match our records.',
        'throttled' => 'Too many register attempts. Please try again in :seconds seconds.',
    ],

];
