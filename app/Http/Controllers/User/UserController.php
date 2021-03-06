<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserInterface;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    protected $users;

    public function __construct(UserInterface $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->all();

        return UserResource::collection($users);
    }
}
