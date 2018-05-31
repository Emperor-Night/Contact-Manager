@extends("layouts.master")

@section("content")

    <div class="card">

        <div class="card-header">
            @if(isset($contact))
                @section("title","Contact | Edit")
            <h3>Edit contact</h3>
            @else
                @section("title","Contact | Create")
            <h3>Create contact</h3>
            @endif
        </div>

        <div class="card-body">

            @if(isset($contact))
                {!! Form::model($contact,["method"=>"PATCH","route"=>["contacts.update",$contact->id],"files"=>true]) !!}
            @else
                {!! Form::open(["method"=>"POST","route"=>"contacts.store","files"=>true]) !!}
            @endif

            <div class="row">

                <div class="col-sm-7">

                    <div class="form-group">
                        {!! Form::label("name","Name :") !!}
                        {!! Form::text("name",null,["class"=>"form-control " . getValClass($errors,"name")]) !!}
                        {!! valMsg($errors, "name") !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label("company","Company :") !!}
                        {!! Form::text("company",null,["class"=>"form-control " . getValClass($errors,"company")]) !!}
                        {!! valMsg($errors, "company") !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label("email","Email :") !!}
                        {!! Form::email("email",null,["class"=>"form-control " . getValClass($errors,"email")]) !!}
                        {!! valMsg($errors, "email") !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label("phone","Phone :") !!}
                        {!! Form::text("phone",null,["class"=>"form-control " . getValClass($errors,"phone")]) !!}
                        {!! valMsg($errors, "phone") !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label("address","Address :") !!}
                        {!! Form::textarea("address",null,["class"=>"form-control " . getValClass($errors,"address")]) !!}
                        {!! valMsg($errors, "address") !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label("group_id","Group :") !!}
                        {!! Form::select("group_id",$formGroups,null,["class"=>"form-control " . getValClass($errors,"group_id")]) !!}
                        {!! valMsg($errors, "group_id") !!}
                    </div>

                    <a href="#" class="btn btn-default mb-3" id="showHiddenDiv">Add group</a>

                    <div class="form-group" id="hiddenDiv">
                        {!! Form::label("new_group","New Group :") !!}
                        {!! Form::text("new_group",null,["class"=>"form-control"]) !!}
                        <a href="#" id="newGroupSave" class="btn btn-default mt-1">Save new group</a>
                    </div>

                    <div class="form-group">
                        @if(isset($contact))
                            {!! Form::button("Update <i class='fas fa-save'></i>",["class"=>"btn btn-success","type"=>"submit"]) !!}
                        @else
                            {!! Form::button("Create <i class='fas fa-save'></i>",["class"=>"btn btn-success","type"=>"submit"]) !!}
                        @endif
                        <a href="{{ route("contacts.index") }}" class="btn btn-default">Cancel</a>
                    </div>

                </div>

                <div class="col-sm-5">

                    <label for="image">
                        @if(isset($contact))
                            <img src="{{ $contact->getPhotoPath() }}"
                                 alt="{{ $contact->name }}" class="rounded-circle" width="250">
                        @else
                            <img src="/storage/images/contacts/uni.png" alt="templateImage" class="rounded-circle"
                                 width="250">
                        @endif
                    </label>

                    <div class="form-group">
                        {!! Form::label("image","Choose photo :") !!}
                        {!! Form::file("image",["class"=>"form-control " . getValClass($errors,"image")]) !!}
                        {!! valMsg($errors, "image") !!}
                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection

@section("scripts")
    @include("inc.formScript")
@endsection