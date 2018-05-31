<?php

$currentRoute = Route::currentRouteName();

if ($currentRoute == "contacts.index" || $currentRoute == "group.contacts") {
    $url = route("contacts.bulk.destroy");
} else if ($currentRoute == "groups.index") {
    $url = route("groups.bulk.destroy");
}

?>


<script>

    $(document).ready(function () {

        var token = $("meta[name='csrf-token']").attr("content");


        // Activating delete modal
        $("body").on("click", "#bulkDeleteButton", function () {

            $("#confirmDelete").off().on("click", function () {

                var ids = [];
                $(".checkbox:checked").each(function () {
                    ids.push($(this).val());
                });

                $.ajax({
                    type: "DELETE",
                    url: "{{ $url }}",
                    data: {
                        _token: token,
                        ids: ids
                    },
                    success: function () {
                        location.reload();
                    }
                });

            });

        });


        // Selecting or deselecting all items
        $("body").on("click", "#checkAll", function () {

            if ($(this).prop("checked")) {
                $(".checkbox").each(function () {
                    $(this).prop("checked", true);
                });
            } else {
                $(".checkbox").each(function () {
                    $(this).prop("checked", false);
                });
            }

        });


    });

</script>
