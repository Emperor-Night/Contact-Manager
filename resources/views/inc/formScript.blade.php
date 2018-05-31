<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#hiddenDiv").hide();

    $("body").on("click", "#showHiddenDiv", function (event) {
        event.preventDefault();
        $("#hiddenDiv").slideToggle(500, function () {
            $("#new_group").focus();
        });
    });

    $("body").on("keypress", "#new_group", function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $("body").on("click", "#newGroupSave", function (event) {

        event.preventDefault();

        var input = $("#new_group");
        var selectGroup = $("#group_id");
        var sidebar = $("#sidebar");
        var value = input.val();

        $.ajax({
            method: "POST",
            url: "{{ route("groups.store") }}",
            data: {name: value},
            success: function (response) {

                var error = response.customError;

                if (error) {
                    return showValidationStatus(error, input);
                }

                var newGroup = response.newGroup;
                var groups = response.groups;

                input.removeClass("is-invalid");
                input.next(".invalid-feedback").remove();
                input.val("");

                sidebar.children(".deleteItem").remove();
                selectGroup.empty();

                $.each(groups, function (index, group) {

                    var sidebarItem = `
                                    <a href="/group/${group.id}/contacts" class="list-group-item deleteItem">
                                        ${group.name}
                                        <span class="badge badge-info float-right p-2 rounded-circle">
                                            ${group.contactsCount}
                                        </span>
                                    </a>
                                    `;

                    var status = false;
                    if (newGroup.id === group.id) {
                        status = true;
                    }

                    var optionItem = $("<option></option>")
                        .attr("value", group.id)
                        .attr("selected", status)
                        .text(group.name);

                    sidebar.append(sidebarItem);
                    selectGroup.append(optionItem);

                });

            },
            error: function (xhr) {

                var error = xhr.responseJSON.errors.name[0];
                if (error) {
                    return showValidationStatus(error, input);
                }

            }

        });

    });


    // Custom function
    function showValidationStatus(error, input) {
        input.next(".invalid-feedback").remove();
        input.addClass("is-invalid")
            .after("<span class='invalid-feedback'><strong>" + error + "</strong></span>");
        return;
    }

</script>