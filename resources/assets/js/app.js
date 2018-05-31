require('./bootstrap');


$(document).ready(function () {

    $("#customSuccess,#customInfo,#customError").delay(4000).fadeToggle(2500);


    $("body").on("click", ".deleteButton", function (event) {
        event.preventDefault();

        var form = $(this).parent();
        $("#confirmDelete").off().on("click", function () {
            form.submit();
        });

    });


    // Search contacts PROPER method

    $("body").on("keyup", "#searchContacts", function () {

        var token = $("meta[name='csrf-token']").attr("content");
        var searchValue = $(this).val().trim();
        var table = $("#table");
        var bulkDeleteForm = $("#bulkDeleteForm");
        var cardBody = $(".card-body");

        $.ajax({

            method: "GET",
            data: {
                searchContacts: searchValue
            },

            success: function (response) {

                var contacts = response.contacts;

                table.empty();
                cardBody.children("h3.message").remove();

                if (contacts.length) {
                    bulkDeleteForm.show();
                } else {
                    bulkDeleteForm.hide();
                    cardBody.append("<h3 class='text-center message'>No contact found</h3>");
                    return;
                }

                var heading = `
                        <tr class="tableHeading">
                            <th>
                                ${checkboxAll()}
                            </th>
                            <th>Photo</th>
                            <th>Contact Info</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        `;

                table.append(heading);

                $.each(contacts, function (index, contact) {

                    var content = `
                        <tr>
                            <td>
                                ${checkbox(contact)}
                            </td>
                            <td>
                                <img src="${contact.photoName}" alt="${contact.name}" class="rounded-circle" width="100">
                            </td>
                            <td>
                                <h4 class="card-title">${contact.name}</h4>
                                <p class="card-text">${contact.phone}</p>
                                <p class="card-text">${contact.email}</p>
                                <p class="card-text">${contact.company}</p>
                            </td>
                            <td>
                                <a href="/contacts/${contact.id}/edit" class="btn btn-info">
                                    Edit
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <form action="/contacts/${contact.id}" method="POST">

                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="${token}">
                                    <button class="btn btn-danger deleteButton"
                                    type="submit" data-toggle="modal" data-target="#deleteModal">
                                        Delete <i class='far fa-trash-alt'></i>
                                    </button>

                                </form>
                            </td>
                        </tr>
                `;

                    table.append(content);

                });

            }

        });

    });


    // Search groups PROPER method

    $("body").on("keyup", "#searchGroups", function () {

        var token = $("meta[name='csrf-token']").attr("content");
        var searchValue = $(this).val().trim();
        var table = $("#table");
        var bulkDeleteForm = $("#bulkDeleteForm");
        var cardBody = $(".card-body");

        $.ajax({

            method: "GET",
            data: {
                searchGroups: searchValue
            },

            success: function (response) {

                var groups = response.groups;

                table.empty();
                cardBody.children("h3.message").remove();

                if (groups.length) {
                    bulkDeleteForm.show();
                } else {
                    bulkDeleteForm.hide();
                    cardBody.append("<h3 class='text-center message'>No group found</h3>");
                    return;
                }

                var heading = `
                            <tr class="tableHeading">
                                <th>
                                ${checkboxAll()}
                                </th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        `;

                table.append(heading);

                $.each(groups, function (index, group) {

                    var content = `
                        <tr>
                            <td>
                                ${checkbox(group)}
                            </td>
                            <td class="groupTDName">${group.name}</td>
                            <td>${group.created}</td>
                            <td>${group.updated}</td>
                            <td>
                                <a href="/groups/${group.id}/edit" class="btn btn-info">
                                    Edit
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                            <td>

                                <form action="/groups/${group.id}" method="POST">

                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="${token}">
                                    <button class="btn btn-danger deleteButton"
                                    type="submit" data-toggle="modal" data-target="#deleteModal">
                                        Delete <i class='far fa-trash-alt'></i>
                                    </button>

                                </form>

                            </td>
                        </tr>
                `;

                    table.append(content);

                });

            }

        });

    });


    $("body").on("submit", "#searchContactsForm", function (event) {
        event.preventDefault();
    });

    $("body").on("submit", "#searchGroupsForm", function (event) {
        event.preventDefault();
    });


    // Custom functions
    function checkboxAll() {
        return `
            <div class="pretty p-svg p-curve p-jelly p-bigger">
                <input id="checkAll" name="bulk" type="checkbox">
                <div class="state p-success">
                    <!-- svg path -->
                    <svg class="svg svg-icon" viewBox="0 0 20 20">
                        <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                    </svg>
                    <label></label>
                </div>
            </div>
            `
    }

    function checkbox(model) {
        return `
            <div class="pretty p-svg p-curve p-jelly p-bigger">
                <input class="checkbox" name="bulk" type="checkbox" value="${model.id}">
                <div class="state p-success">
                    <!-- svg path -->
                    <svg class="svg svg-icon" viewBox="0 0 20 20">
                    <path d="M7.629,14.566c0.125,0.125,0.291,0.188,0.456,0.188c0.164,0,0.329-0.062,0.456-0.188l8.219-8.221c0.252-0.252,0.252-0.659,0-0.911c-0.252-0.252-0.659-0.252-0.911,0l-7.764,7.763L4.152,9.267c-0.252-0.251-0.66-0.251-0.911,0c-0.252,0.252-0.252,0.66,0,0.911L7.629,14.566z" style="stroke: white;fill:white;"></path>
                    </svg>
                    <label></label>
                </div>
            </div>
            `
    }


    // Searches EASY way

    // $("body").on("keyup", "#searchContacts", function () {
    //     filter("contacts", $(this).val().trim().toLowerCase());
    // });
    //
    // $("body").on("keyup", "#searchGroups", function () {
    //     filter("groups", $(this).val().trim().toLowerCase());
    // });
    //
    // function filter(modelName, searchValue) {
    //
    //     var bulkDeleteForm = $("#bulkDeleteForm");
    //     var cardBody = $(".card-body");
    //     var tableHeading = $(".tableHeading");
    //     var foundItems = 0;
    //
    //
    //     $(".groupTDName").each(function () {
    //         var tdValue = $(this).text().toLowerCase();
    //         var status = tdValue.indexOf(searchValue) >= 0;
    //         $(this).parent().toggle(status);
    //         if (status) {
    //             foundItems++;
    //         }
    //     });
    //
    //     cardBody.children("h3").remove();
    //
    //     if (foundItems) {
    //         bulkDeleteForm.show();
    //         tableHeading.show();
    //     } else {
    //         bulkDeleteForm.hide();
    //         tableHeading.hide();
    //         cardBody.append("<h3 class='text-center message'>No " + modelName + " found</h3>");
    //     }
    //
    // }
    //
    // $("body").on("submit", "#searchContactsForm", function (event) {
    //     event.preventDefault();
    // });
    //
    // $("body").on("submit", "#searchGroupsForm", function (event) {
    //     event.preventDefault();
    // });


});