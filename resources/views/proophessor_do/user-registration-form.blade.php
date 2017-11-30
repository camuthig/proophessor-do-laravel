@extends('proophessor_do.base')

@section('content')
<h1>Register a new User</h1>
<div class="row">
    <div class="col-md-12">
        <user-form></user-form>
    </div>
</div>
@endsection

@section('page_js')
    <script>
        $(function() {
            @riotTag('proophessor_do/riot-user-form')

            var UserForm = ProophRiot.App.create();

            console.log(UserForm);

            $( function() {
                UserForm.bootstrap( "user-form" ).ready();
            } );
        });
    </script>
@endsection

