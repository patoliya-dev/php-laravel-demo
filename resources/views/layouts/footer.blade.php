</div>
</body>

</html>

<script>
    //user----------------
    //image preview
    function setImage(event) {

        var preview = document.getElementById('image');
        var image = URL.createObjectURL(event.target.files[0]);
        preview.src = image;
        preview.height = "200";
        preview.width = "200"
    }

    //edit data
    function editData(id) {

        $.ajax({
            url: "dashboard/edit/" + id,
            type: "get",
            dataType: "json",
            success: function(data) {

                var editId = $('#editid').val(data.user.id);
                if (editId) {
                    $('#firstName').val(data.user.first_name);
                    $('#lastName').val(data.user.last_name);
                    var image = document.getElementById('image');
                    let imageUrl = "{{ env('DO_IMAGE') }}";
                    image.src = imageUrl + data.user.image;
                    $("#edit").modal('show');
                }
            }
        });
    }

    // update data :
    $(document).on('click', '#save', function(e) {

        e.preventDefault();
        if ($("#ModalData").valid() == false) {
            return false;
        }

        var userData = new FormData();
        var id = $('#editid').val();
        userData.append('firstName', $('input[name=firstName]').val());
        userData.append('lastName', $('input[name=lastName]').val());
        userData.append('image', $('input[type="file"]')[0].files[0]);

        $.ajax({
            url: "dashboard/update/" + id,
            type: "post",
            dataType: 'json',
            data: userData,
            contentType: false,
            processData: false,
            success: function(data) {

                if (data.status == 200) {
                    location.reload();
                }
            },
            error: function(response) {
                $.each(response.responseJSON.errors, function(field_name, error) {
                    $('#' + field_name + '_error').text(error);

                })
            }
        });

    });

    // reset error
    function resetError() {
        $('#ModalData').validate().resetForm();
    }

    $(document).ready(function() {

        // jquery validation for update modal
        jQuery.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || /^[A-Za-z ]+$/.test(value)
        });

        var validator = $("#ModalData").validate({

            rules: {
                firstName: {
                    required: true,
                    alpha: true
                },
                lastName: {
                    required: true,
                    alpha: true

                },
            },
            messages: {
                firstName: {
                    required: "Enter first name",
                    alpha: "Only alphabets allowed",
                },
                lastName: {
                    required: "Enter last name",
                    alpha: "Only alphabets allowed",
                },
            },
        });

        $('.closeBtn').click(function() {
            validator.resetForm();
        });
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // admin -------------------
    //update role
    function updateRole(id) {
        $.ajax({
            url: "dashboard/updateRole/" + id,
            type: "put",
            dataType: 'JSON',
            success: function(data) {
                if (data.status = 200) {
                    location.reload();
                }
            }
        });
    }
    //delete data
    function deleteData(id) {

        swal("Are you sure you want to delete this book", {
            dangerMode: true,
            buttons: true,
            icon: "warning",
        }).then(function(isConfirm) {

            if (isConfirm) {

                $.ajax({
                    url: "dashboard/delete/" + id,
                    type: "delete",
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status = 200) {
                            location.reload();
                        }
                    }
                });
            }
        });
    }
</script>
