<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Prooph\ProophessorDo\Projection\User\UserFinder;

class UserTodoFormController extends Controller
{
    /**
     * @var UserFinder
     */
    private $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function get(Request $request, $userId): View
    {
        $invalidUser = true;

        $user = $this->userFinder->findById($userId);
        if ($user) {
            $invalidUser = false;
        }

        return view('proophessor_do/user-todo-form', [
            'invalidUser' => $invalidUser,
            'user' => $user,
        ]);
    }
}
