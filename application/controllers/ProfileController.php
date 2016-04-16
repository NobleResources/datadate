<?php

use DataDate\Database\Models\User;
use DataDate\Http\Controller;
use DataDate\Http\Filters\AuthenticatesUser;
use DataDate\Http\Request;
use DataDate\Http\Responses\FileResponse;
use DataDate\Views\View;

class ProfileController extends Controller
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
     *
     * @return FileResponse
     */
    public function post(Request $request)
    {
        $this->validator->validate($request, [
            'profile_picture' => 'image',
        ]);

        $user = $this->session->getUser();
        $this->storePicture($request, $user);
        $user->description = $request->description;
        $user->save();

        return $this->redirector->back();
    }

    /**
     * @param Request $request
     * @param         $user
     *
     * @throws Exception
     */
    private function storePicture(Request $request, User $user)
    {
        $profilePicture = $request->file('profile_picture');

        if (isset($profilePicture)) {

            $profilePicture->move($this->generateFileName($profilePicture));
            $user->profile_picture = $profilePicture->getPath();



        }
    }

    /**
     * @param $profilePicture
     *
     * @return string
     */
    private function generateFileName($profilePicture)
    {
        return APPPATH . 'uploads/' . str_random(10) . '.' . $profilePicture->getExtension();
    }
}