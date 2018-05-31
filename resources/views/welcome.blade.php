@extends("layouts.app")

@section("content")

    <div class="jumbotron text-center">
        <div class="container">

            <h1>Free online contact manager</h1>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium commodi dicta ducimus
                incidunt ipsum quam repudiandae voluptatibus? Adipisci alias beatae, facilis inventore officiis quam
                quas quo repellat repudiandae.
            </p>

            @guest
            <a href="{{ route("register") }}" class="btn btn-info mr-4">Sign up</a> OR
            <a href="{{ route("login") }}" class="btn btn-success ml-4">Log in</a>
            @else
                {!! Form::open(["method"=>"POST","route"=>"logout"]) !!}
                <div class="form-group">
                    {!! Form::button("Logout <i class='fas fa-sign-out-alt'></i>",["class"=>"btn btn-danger","type"=>"submit"]) !!}
                </div>
                {!! Form::close() !!}
            @endguest

        </div>
    </div>


@endsection