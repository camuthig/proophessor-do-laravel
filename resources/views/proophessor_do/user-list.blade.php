@extends('proophessor_do.base')
@section('content')
<h1>Registered Users</h1>
<div class="row">
    <div class="col-md-12">
        @empty($users)
            <div class="alert alert-warning">
                <strong>No user registered yet. Do you want to <a href="{{ route('page::user-registration-form') }}">add yourself</a>?</strong>
            </div>
        @endempty
        <div class="list-group">
            @foreach ($users as $user)
                <a href="{{ route('page::user-todo-list', ['userId' => $user->id]) }}" class="list-group-item"><strong>{{ $user.name }}</strong>
                <small class="text-info">
                    &nbsp;&nbsp;open Todos: {{ $user->open_todos + $user->expired_todos }}&nbsp;&nbsp;|
                    &nbsp;&nbsp;expired Todos: {{ $user->expired_todos }}&nbsp;&nbsp;|
                    &nbsp;&nbsp;closed Todos:&nbsp;{{ $user->done_todos }}
                </small></a>
            @endforeach
        </div>
    </div>
</div>
@endsection
