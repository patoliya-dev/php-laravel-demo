@include('layouts.header')

<div class="container-fluid h-100 design">
    <section>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">welcome to : <b> {{ Auth::user()->email  }}  </b></a>
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
                    @foreach ($users as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ $value->email }}</td>
                            <td><img src="{{ asset(env('DO_IMAGE') . $value->image) }}" alt="" height="40" width="40"></td>
                            <td>
                                <a onclick='deleteData({{ $value->id }})'><i class="fa-solid fa-trash-can"></i></a>
                                <button onclick='updateRole({{ $value->id }})' class="btn btn-primary">Make
                                    Admin</button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>

</div>

@include('layouts.footer')

