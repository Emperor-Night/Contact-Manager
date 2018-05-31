@section("styles")
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css">
@endsection

{!! Form::open(["id"=>"bulkDeleteForm"]) !!}
<div class="row">
    <div class="form-group col-sm-3">
        {!! Form::select("status",[""=>"Bulk delete"],null,["class"=>"form-control"]) !!}
    </div>

    <div class="form-group col-sm-2">
        {!! Form::button("Delete <i class='fas fa-trash'></i>",
        ["class"=>"btn btn-success","data-toggle"=>"modal","data-target"=>"#deleteModal","id"=>"bulkDeleteButton"]) !!}
    </div>
</div>
{!! Form::close() !!}

@include("inc.deleteModal")

@section("scripts")
    @include("inc.bulkDeleteScript")
@endsection
