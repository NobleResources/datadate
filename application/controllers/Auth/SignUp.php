<?php

use DataDate\Extensions\BaseController;
use DataDate\Http\Request;
use DataDate\Views\View;

class SignUp extends BaseController
{
    public function get()
    {
        return new View('auth.signup', [], $this->session->get('errors'), $this->session->get('old'));
    }

    public function post(Request $request)
    {
        $errors = $this->validator->validate($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        if (!empty($errors)) {
            return $this->redirector->to('/signup')
                                    ->withErrors($errors)
                                    ->withOld($request->except([
                                        'password',
                                        'password_confirmation']
                                    ));
        }

        return 'Succes!';
    }
}