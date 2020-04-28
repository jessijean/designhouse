<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Rules\MatchOldPassword;
use App\Rules\CheckSamePassword;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    public function updateProfile(Request $request, $id = null)
    {
        if (User::where('id', $id)->exists()) {

            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->tagline = $request->input('tagline');
            $user->about = $request->input('about');
            $user->formatted_address = $request->input('formatted_address');

            if ($user->save()) {
                return new UserResource($user);
            }

        } else {
            $id = Auth::user()->id;

            $user = User::findOrFail($id);

            $user->name = $request->input('name');
            $user->tagline = $request->input('tagline');
            $user->about = $request->input('about');
            $user->formatted_address = $request->input('formatted_address');

            if ($user->save()) {
                return new UserResource($user);
            }
        }

    }

    public function updatePassword(Request $request) {

        $validator = Validator::make($request->all(),[
            'current_password'  => ['required', new MatchOldPassword()],
            'password'          => ['required','min:8', 'confirmed', new CheckSamePassword()]
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return response()->json([
               'message' => $error
            ]);
        } else {

            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $password = bcrypt($request->input('password'));
            $user->password = $password;

            if ($user->save()) {
                return new UserResource($user);
            }

            return response()->json([
                'message' => 'Password updated',
            ], 200);

        }
    }
}
