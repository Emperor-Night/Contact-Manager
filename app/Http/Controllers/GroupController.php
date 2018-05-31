<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    protected $rules = [
        "name" => "required|max:255"
    ];

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $groups = auth()->user()->groups()->filter()->get();

        if (request()->ajax()) {
            $groups = $this->addProps($groups);
            return response()->json(["groups" => $groups]);
        }

        return view("groups.index", compact("groups"));
    }

    public function create()
    {
        return view("groups.form");
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        $user = auth()->user();
        $data["user_id"] = $user->id;

        if ($this->userIsOwner($data["name"])) {

            if ($request->ajax()) {
                return response()->json(["customError" => "You already have that group. Please choose another one !"]);
            } else {
                return back()->withInfo("You already have that group. Please choose another one !");
            }

        }

        $newGroup = Group::create($data);

        if ($request->ajax()) {
            $groups = $user->groups()->order()->get();
            $groups = $this->addProps($groups);
            return response()->json(["newGroup" => $newGroup, "groups" => $groups]);
        }

        return back()->withSuccess("Group created successfully !");
    }

    public function edit(Group $group)
    {
        $this->authorize("modify", $group);
        return view("groups.form", compact("group"));
    }

    public function update(Request $request, Group $group)
    {
        $this->authorize("modify", $group);
        $data = $request->validate($this->rules);

        if ($data["name"] != $group->name) {
            if ($this->userIsOwner($data["name"])) {
                return back()->withInfo("You already have that group. Please choose another one !");
            }
        }

        $group->update($data);

        return redirect()->route("groups.index")
            ->withSuccess("Group updated successfully !");
    }

    public function destroy(Group $group)
    {
        $this->authorize("modify", $group);
        foreach ($group->contacts as $contact) {
            $contact->deletePhoto();
        }
        $group->delete();

        return back()->withSuccess("Group deleted successfully !");
    }


    // Custom methods
    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            "ids" => "required"
        ]);

        foreach ($data["ids"] as $id) {
            $group = Group::findOrFail($id);
            $this->authorize("modify", $group);
            foreach ($group->contacts as $contact) {
                $contact->deletePhoto();
            }
            $group->delete();
        }

    }

    public function userIsOwner($name)
    {
        $arr = Group::where("name", $name)->pluck("user_id", "id")->toArray();
        return in_array(auth()->id(), $arr) ? true : false;
    }

    public function addProps($groups)
    {
        foreach ($groups as $group) {
            $group->contactsCount = $group->contacts()->count();
            $group->created = $group->created_at->toFormattedDateString();
            $group->updated = $group->updated_at->toFormattedDateString();
        }
        return $groups;
    }

    public function contacts(Group $group)
    {
        $this->authorize("modify", $group);
        $contacts = $group->contacts()->addedRelations()->filter()->get();

        foreach ($contacts as $contact) {
            $contact->photoName = $contact->getPhotoPath();
        }

        if (request()->ajax()) {
            return response()->json(["contacts" => $contacts]);
        }

        return view("groups.contacts", compact("contacts", "group"));
    }


}
