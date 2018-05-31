<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

                @if(auth()->check())
                    <li>
                        <a class="nav-link {{ checkRoute("home") }}" href="{{ route("home") }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ checkRoute(["contacts.index","contacts.create","contacts.edit"]) }}"
                           href="{{ route('contacts.index') }}">
                            Contacts
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ checkRoute(["group.contacts","groups.index","groups.create","groups.edit"]) }}"
                           href="{{ route('groups.index') }}">
                            Groups
                        </a>
                    </li>
                @endif

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else

                    @if(checkRoute(["contacts.index","group.contacts"]))

                        {!! Form::open(["method"=>"GET","class"=>"form-inline","id"=>"searchContactsForm"]) !!}
                        {!! Form::text("searchContacts",null,["class"=>"form-control","placeholder"=>"Search contacts...","id"=>"searchContacts"]) !!}
                        {!! Form::close() !!}

                    @elseif(checkRoute("groups.index"))

                        {!! Form::open(["method"=>"GET","class"=>"form-inline","id"=>"searchGroupsForm"]) !!}
                        {!! Form::text("searchGroups",null,["class"=>"form-control","placeholder"=>"Search groups...","id"=>"searchGroups"]) !!}
                        {!! Form::close() !!}

                    @endif

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
            </ul>
        </div>
    </div>
</nav>