<?php

use DataDate\Http\Controller;
use DataDate\Http\Request;

class SignUp extends Controller
{
    public function get()
    {
        return $this->viewBuilder->build('auth.signup');
    }

    public function post(Request $request)
    {
        $this->validator->validate($request->post(), [
            'password' => 'required|min:6|confirmed',
            'email' => 'required|email|unique:user',
            'nickname' => 'required|between:6,20|unique:user',
            'first_name' => 'required|between:1,50',
            'last_name' => 'required|between:1,50',
            'gender' => 'required',
            'birthday' => 'required'
        ]);

        $attributes = array_except($request->post(), 'password_confirmation');
        $attributes['password'] = password_hash($request->post('password'), PASSWORD_BCRYPT);

        $this->session->setUser(User::create($attributes));

        return $this->redirector->to('/profile');
    }
}