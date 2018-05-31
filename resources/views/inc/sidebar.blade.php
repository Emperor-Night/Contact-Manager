<div class="list-group" id="sidebar">

    <a href="{{ route("contacts.index") }}"
       class="list-group-item {{ checkRoute(["contacts.index","contacts.create","contacts.edit"]) }}">
        All contacts
        <span class="badge badge-info float-right p-2 rounded-circle">
                {{ auth()->user()->contacts()->count() }}
        </span>
    </a>

    <a href="{{ route("groups.index") }}"
       class="list-group-item {{ checkRoute(["groups.index","groups.create","groups.edit"]) }}">
        All groups
        <span class="badge badge-info float-right p-2 rounded-circle">
                {{ auth()->user()->groups()->count() }}
        </span>
    </a>

    @foreach($groups as $group)
        <a href="{{ route("group.contacts",$group->id) }}"
           class="list-group-item deleteItem {{ Request::segment(1) == "group" && Request::segment(2) == $group->id ? "active" : "" }}">
            {{ $group->name }}
            <span class="badge badge-info float-right p-2 rounded-circle">
                {{ $group->contacts()->count() }}
            </span>
        </a>
    @endforeach

</div>