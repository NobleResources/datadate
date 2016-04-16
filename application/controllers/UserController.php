<?php

use DataDate\Database\Models\User;
use DataDate\File;
use DataDate\Http\Controller;
use DataDate\Http\Exceptions\NotFoundException;
use DataDate\Http\Filters\AuthenticatesUser;
use DataDate\Http\Request;
use DataDate\Http\Responses\FileResponse;

class UserController extends Controller
{
    public function filters()
    {
        return [new AuthenticatesUser($this->redirector)];
    }

    public function show(Request $request)
    {
        $parameters = $request->parameter();
        $userId = $parameters[0];
        $user = User::find($userId);
        if ($user === null) {
            throw new NotFoundException;
        }

        return $this->viewBuilder->build('users.show', ['model' => $user]);
    }

    public function picture(Request $request)
    {
        $parameters = $request->parameter();
        $userId = $parameters[0];
        $user = User::find($userId, ['profile_picture']);

        return new FileResponse(File::fromPath($user->profile_picture));
    }
}