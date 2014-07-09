<?php

Route::filter("auth", function()
{
    return Redirect::route("user/login");
});

Route::filter("guest", function()
{
    if (Auth::check())
    {
        return Redirect::route("user/profile");
    }
});

Route::filter("csrf", function()
{
    if (Session::token() != Input::get("_token"))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});