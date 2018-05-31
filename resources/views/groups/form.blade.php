@extends("layouts.master")

@section("content")

    <div class="card">

        <div class="card-header">
            @if(isset($group))
                @section("title","Group | Edit")
                <h3>Edit group</h3>
            @else
                @section("title","Group | Create")
                <h3>Create group</h3>
            @endif
        </div>

        <div class="card-body">

            @if(isset($group))
                {!! Form::model($group,["method"=>"PATCH","route"=>["groups.update",$group->id]]) !!}
            @else
                {!! Form::open(["method"=>"POST","route"=>"groups.store"]) !!}
            @endif

            <div class="form-group">
                {!! Form::label("name","Name :") !!}
                {!! Form::text("name",null,["class"=>"form-control " . getValClass($errors,"name")]) !!}
                {!! valMsg($errors, "name") !!}
            </div>

            <div class="form-group">
                @if(isset($group))
                    {!! Form::button("Update <i class='fa fa-save'></i>",["class"=>"btn btn-success","type"=>"submit"]) !!}
                @else
                    {!! Form::button("Create <i class='fas fa-save'></i>",["class"=>"btn btn-success","type"=>"submit"]) !!}
                @endif
            </div>

            {!! Form::close() !!}

        </div>

    </div>


@endsection