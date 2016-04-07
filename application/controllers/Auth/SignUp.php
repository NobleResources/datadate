<?php

use DataDate\Http\Controller;
use DataDate\Http\Request;
use DataDate\Session;
use DataDate\Views\View;

class SignUp extends Controller
{
    public function get(Session $session)
    {
        return new View('auth.signup', [], $session->get('errors'), $session->get('old'));
    }

    public function post(Request $request)
    {
        $this->validator->validate($request->post(), [
            'email' => 'required|email|unique:user',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'email' => $request->post('email'),
            'password' => password_hash($request->post('password'), PASSWORD_BCRYPT),
        ]);


        var_dump($user);
    }
}