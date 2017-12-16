<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Prooph\ProophessorDo\Projection\Todo\TodoFinder;
use Prooph\ProophessorDo\Projection\User\UserFinder;

class UserTodoListController extends Controller
{
    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @var TodoFinder
     */
    private $todoFinder;

    public function __construct(UserFinder $userFinder, TodoFinder $todoFinder)
    {
        $this->userFinder = $userFinder;
        $this->todoFinder = $todoFinder;
    }

    public function get(Request $request, $userId): View
    {
        $user  = $this->userFinder->findById($userId);
        $todos = $this->todoFinder->findByAssigneeId($userId);

        return view('proophessor_do/user-todo-list', [
            'user' => $user,
            'todos' => $todos,
        ]);
    }
}
