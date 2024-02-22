<?php
function index()
{
    $user = Auth::user();

    switch ($user->role) {
        case 'customer':
            return view('customer');
        case 'coach':
            return view('coach');
        case 'admin':
            return view('admin');
        default:
            return view('home');
    }
}
