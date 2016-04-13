<?php

use DataDate\Http\Controller;
use DataDate\Http\Filters\AuthenticatesUser;
use DataDate\Http\Request;
use DataDate\Views\View;

class Profile extends Controller
{
    /**
     * @return array
     */
    public function filters()
    {
        return [new AuthenticatesUser($this->redirector)];
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function get(Request $request)
    {
        return $this->viewBuilder->build('profile', ['model' => $request->getUser()]);
    }

    /**
     * @param Request $request
     */
    public function post(Request $request)
    {
        $this->validator->validate($request->post(), [
        
        ]);

        $user = $request->getUser();
        $user->update($request->post());
    }
}