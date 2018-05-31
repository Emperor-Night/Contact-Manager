@extends("layouts.app")

@section("content")

    <div class="jumbotron text-center">
        <div class="container">
            <h1>Hello {{ auth()->user()->name }} !</h1>
            <p class="lead">Welcome back to Contact Manager App</p>
            <a href="{{ route("contacts.index") }}" class="btn btn-info btn-lg">
                Manage your contacts
            </a>
        </div>
    </div>


@endsection