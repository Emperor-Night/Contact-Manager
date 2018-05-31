<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{

    protected $rules = [
        "name"     => "required|max:255",
        "company"  => "required|max:255",
        "email"    => "required|email|max:255",
        "phone"    => "required|max:255",
        "address"  => "required|max:255",
        "group_id" => "required|integer"
    ];

    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $contacts = auth()->user()->contacts()->addedRelations()->filter()->get();

        if (request()->ajax()) {
            $contacts = $this->addPhotoNameProp($contacts);
            return response()->json(["contacts" => $contacts]);
        }

        return view("contacts.index", compact("contacts"));
    }

    public function create()
    {
        return view("contacts.form");
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        $data["user_id"] = auth()->id();

        if ($this->userIsOwner($data["name"])) {
            return back()->withInfo("You already have that contact. Please choose another one !");
        }

        $contact = new Contact($data);
        $contact->checkForPhoto($request);
        $contact->save();

        return back()->withSuccess("Contact created successfully !");
    }

    public function edit(Contact $contact)
    {
        $this->authorize("modify", $contact);
        return view("contacts.form", compact("contact"));
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorize("modify", $contact);
        $data = $request->validate($this->rules);

        if ($data["name"] != $contact->name) {
            if ($this->userIsOwner($data["name"])) {
                return back()->withInfo("You already have that contact. Please choose another one !");
            }
        }

        $contact->checkForPhoto($request, "update");
        $contact->update($data);

        return redirect()->route("contacts.index")
            ->withSuccess("Contact updated successfully !");
    }

    public function destroy(Contact $contact)
    {
        $this->authorize("modify", $contact);
        $contact->deletePhoto();
        $contact->delete();
        return back()->withSuccess("Contact and photo deleted successfully !");
    }


    // Custom methods
    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            "ids" => "required"
        ]);

        foreach ($data["ids"] as $id) {
            $contact = Contact::findOrFail($id);
            $this->authorize("modify", $contact);
            $contact->deletePhoto();
            $contact->delete();
        }

    }

    public function userIsOwner($name)
    {
        $arr = Contact::where("name", $name)->pluck("user_id", "id")->toArray();
        return in_array(auth()->id(), $arr) ? true : false;
    }

    public function addPhotoNameProp($contacts)
    {
        foreach ($contacts as $contact) {
            $contact->photoName = $contact->getPhotoPath();
        }
        return $contacts;
    }


}
