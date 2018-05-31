@extends("layouts.master")

@section("title","Groups | Index")

@section("content")

    <div class="card">

        <div class="card-header">

            <h3 class="float-left">All groups</h3>
            <a href="{{ route("groups.create") }}" class="btn btn-warning float-right">
                Create group
                <i class="fas fa-plus"></i>
            </a>

        </div>

        <div class="card-body">

            @if($groups->count())

                @include("inc.bulkDeleteForm")

                <table class="table table-hover" id="table">

                    <tr class="tableHeading">
                        <th>
                            {!! checkbox() !!}
                        </th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    @foreach($groups as $group)
                        <tr>
                            <td>
                                {!! checkbox($group) !!}
                            </td>
                            <td class="groupTDName">{{ $group->name }}</td>
                            <td>{{ $group->created_at->toFormattedDateString() }}</td>
                            <td>{{ $group->updated_at->toFormattedDateString() }}</td>
                            <td>
                                <a href="{{ route("groups.edit",$group->id) }}" class="btn btn-info">
                                    Edit
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                {!! deleteForm(route("groups.destroy",$group->id))  !!}
                            </td>
                        </tr>
                    @endforeach

                </table>

            @else
                <h3 class="text-center">No groups found</h3>
            @endif

        </div>

    </div>


@endsection