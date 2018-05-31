@section("content")

    <div class="card">

        <div class="card-header">

            @if(isset($group))
                <h3 class="float-left">Group | {{ $group->name }} | contacts</h3>
            @else
                <h3 class="float-left">All contacts</h3>
            @endif
            <a href="{{ route("contacts.create") }}" class="btn btn-warning float-right">
                Create contact
                <i class="fas fa-plus"></i>
            </a>

        </div>

        <div class="card-body">

            @if($contacts->count())

                @include("inc.bulkDeleteForm")

                <table class="table table-hover text-center" id="table">

                    <tr class="tableHeading">
                        <th>
                            {!! checkbox() !!}
                        </th>
                        <th>Photo</th>
                        <th>Contact Info</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>

                    @foreach($contacts as $contact)
                        <tr>
                            <td>
                                {!! checkbox($contact) !!}
                            </td>
                            <td>
                                <img src="{{ $contact->getPhotoPath() }}"
                                     alt="{{ $contact->name }}" class="rounded-circle" width="100">
                            </td>
                            <td class="groupTDName">
                                <h4 class="card-title">{{ $contact->name }}</h4>
                                <p class="card-text">{{ $contact->phone }}</p>
                                <p class="card-text">{{ $contact->email }}</p>
                                <p class="card-text">{{ $contact->company }}</p>
                            </td>
                            <td>
                                <a href="{{ route("contacts.edit",$contact->id) }}" class="btn btn-info">
                                    Edit
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                {!! deleteForm(route("contacts.destroy",$contact->id))  !!}
                            </td>
                        </tr>
                    @endforeach

                </table>

            @else
                @if(isset($group))
                    <h3 class="text-center">No | {{ $group->name }} | contacts found</h3>
                @else
                    <h3 class="text-center">No contacts found</h3>
                @endif
            @endif

        </div>

    </div>


@endsection