<?php

use DataDate\Http\Controller;
use DataDate\Http\Request;
use DataDate\Services\Validation\ValidationException;
use DataDate\Views\View;

class SignIn extends Controller
{
    /**
     * @return View
     */
    public function get()
    {
        return $this->viewBuilder->build('auth.signin');
    }

    public function post(Request $request)
    {
        $this->validator->validate($request->post(), [
            'password' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->post('email'))->first();

        if ( ! password_verify($request->post('password'), $user->password)) {
            throw new ValidationException(['credentials' => ['The email and/or password you supplied are incorrect.']]);
        }

        $this->session->store('userId', $user->id);

        return $this->redirector->to('/profile');
    }
}