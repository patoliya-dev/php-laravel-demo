@include('layouts.header')

<div class="container h-100 design">
    <section>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">welcome to : <b> {{ session()->get('email') }} </b></a>
            </div>
        </nav>

        @if (session()->has('message'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="alert-dismissible">
                    <h5 class="text-center">{{ session()->get('message') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <div class="row mb-2">
            <div class="col-md-8 p-2">
                <a href="{{ 'logout' }}" class="btn btn-danger">logout</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th><strong>id</strong></th>
                        <th><strong>first name</strong></th>
                        <th><strong>last name</strong></th>
                        <th><strong>email</strong></th>
                        <th><strong>image</strong></th>
                        <th><strong>Action</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><img src="{{ asset(env('DO_IMAGE') . $user->image) }}" height="40" width="40"></td>
                        <td>
                            <a onclick='editData({{ $user->id }})'><i class="fa-solid fa-pen"></i></a>
                            {{-- <a href="{{ 'user-dashboard/edit/'. $user->id }}"><i class="fa-solid fa-pen"></i></a> --}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- add modal -->
        <div class="modal" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> edit profile </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <img src="" alt="profile picture" id="image" class="rounded-circle image"
                                height="150px" width="150px">
                        </div>
                        <form action="" method="post" id="ModalData" enctype="multipart/form-data">
                            <input type="hidden" id="editid" name="id" value="">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-outline p-2">
                                        <label for="">first name</label>
                                        <span class="error">*</span>
                                        <input type="text" name="firstName" id="firstName" class="form-control">
                                        <span class="back-error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-outline p-2">
                                        <label for="">last name</label>
                                        <span class="error">*</span>
                                        <input type="text" name="lastName" id="lastName" class="form-control">
                                        <span class="back-error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-outline p-2">
                                        <label for="">avtar</label>
                                        <span class="error">*</span>
                                        <input type="file" name="image_file" id="image_file" class="form-control"
                                            onchange="setImage(event)">
                                        <span class="back-error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="save">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<script>
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
            url: "user-dashboard/edit/" + id,
            type: "get",
            dataType: "json",
            success: function(data) {

                console.log(data);
                var editId = $('#editid').val(data.id);

                if (editId) {

                    $('#firstName').val(data.first_name);
                    $('#lastName').val(data.last_name);
                    var image = document.getElementById('image');
                    let imageUrl = "{{ env('DO_IMAGE') }}";
                    image.src = imageUrl + data.image;
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
            url: "user-dashboard/update/" + id,
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
                image_file: {
                    required: true
                }
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
                image_file: {
                    required: "select profile avatar"
                }
            },
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

