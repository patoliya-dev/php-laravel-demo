@include('layouts.header')

<div class="container h-100 design">
    <section>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">welcome to : <b> {{ Auth::user()->email }} </b></a>
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
                <h4 class="pb-3">User Profile</h4>
                <thead>
                    <tr>
                        <th><strong>id</strong></th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th><strong>first name</strong></th>
                        <td>{{ $user->first_name }}</td>
                    </tr>

                    <tr>
                        <th><strong>last name</strong></th>
                        <td>{{ $user->last_name }}</td>
                    </tr>
                    <tr>
                        <th><strong>email</strong></th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th><strong>image</strong></th>
                        <td><img src="{{ asset(env('DO_IMAGE') . $user->image) }}" height="100" width="100"></td>
                    </tr>
                    <tr>
                        <th><strong>Action</strong></th>
                        <td>
                            <a onclick='editData({{ $user->id }})'><i class="fa-solid fa-pen"></i></a>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>


        <!-- add modal -->
        <div class="modal" id="edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> edit profile </h5>
                        <button type="button" class="btn-close" onclick="resetError()" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                                <button type="button" class="btn btn-secondary closeBtn"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@include('layouts.footer')
