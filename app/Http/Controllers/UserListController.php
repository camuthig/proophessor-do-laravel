<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Prooph\ProophessorDo\Projection\User\UserFinder;

class UserListController extends Controller
{
    public function get(Request $request, UserFinder $userFinder): View
    {
        $users = $userFinder->findAll();

        return view('proophessor_do/user-list', [
            'users' => $users,
        ]);
    }
}
