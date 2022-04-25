

// Warn before remove data and redirect
function warnBeforeAction(URL, table) {
    swal(
        {
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "No, cancel!",
            cancelButtonClass: "btn-danger",
            confirmButtonClass: "btn-primary",
            confirmButtonText: "Yes, proceed!",
            closeOnConfirm: false,
        },
        function () {
            var _token = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                method: "DELETE",
                url: URL,
                dataType: "json",
                data: { _token: _token },
                success: function (response) {
                    swal(
                        "Deleted!",
                        "Your imaginary file has been deleted.",
                        "success"
                    );
                    //    swal.close();
                    $(`#${table}`).DataTable().ajax.reload(null, false);
                },
            });
        }
    );
}

function subcategoriesByCategoryId(e,route){
    $('.loading_data').hide();
    $(e).after('<span class="loading_data">Loading...</span>');
    let self = $(e);
    let parentHtml = $(e).parent().parent().parent();
    let categoryId = $(e).val();
    $.ajax({
        type: "GET",
        url: route,
        data: {
            category_id: categoryId
        },
        success: function (response) {
            let option = '<option value="">Select subcategory</option>';
            if (response.responseCode == 1){
                $.each(response.data, function (id, value) {
                    option += '<option value="' + id + '">' + value + '</option>';
                });
            }
            $(parentHtml).find('.subcategoryId').html(option);
            $(self).next().hide();
        }
    });
}
