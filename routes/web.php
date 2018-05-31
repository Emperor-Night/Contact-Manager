<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', ["middleware" => "auth", function () {
    return view('home');
}])->name("home");

Auth::routes();


Route::delete("/contacts/bulkDestroy", "ContactController@bulkDestroy")->name("contacts.bulk.destroy");
Route::delete("/groups/bulkDestroy", "GroupController@bulkDestroy")->name("groups.bulk.destroy");
Route::get("/group/{group}/contacts", "GroupController@contacts")->name("group.contacts");


Route::resources([
    "groups"   => "GroupController",
    "contacts" => "ContactController"
]);
