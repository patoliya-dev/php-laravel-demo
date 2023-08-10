@include('layouts.header')

<div class="container h-100 design">
    <section>

        <div class="row">
            <div class="col-md-12">

                <div class="form-register">
                    <form action="{{ 'register' }}" method="post" enctype="multipart/form-data" id="Register_form">
                        @csrf
                        <h2 class="text-center mt-2">Sign Up</h2>

                        <div class="row">
                            <div class="col-md-6 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="firstName">First Name</label>
                                    <span class="error">*</span>
                                    <input type="text" name="firstName" id="firstName" class="form-control"
                                        value="{{ old('firstName') }}" />
                                    @error('firstName')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="lastName">Last Name</label>
                                    <span class="error">*</span>
                                    <input type="text" name="lastName" id="lastName" class="form-control"
                                        value="{{ old('lastName') }}" />
                                    @error('lastName')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="email">Email</label>
                                    <span class="error">*</span>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="pass">Password</label>
                                    <span class="error">*</span>
                                    <input type="password" name="Password" id="Password" class="form-control"
                                        value="{{ old('Password') }}" />
                                    @error('Password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="form-outline">
                                    <label class="form-label">photo</label>
                                    <span class="error">*</span>
                                    <input type="file" name="image_file" class="form-control" onchange="setImage(event)">
                                </div>
                                @error('image_file')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 p-2">
                                <img src="" id="preview">
                            </div>
                        </div>


                        <div class="pt-3 d-flex justify-content-center">
                            <button class="btn btn-lg btn-dark" name="register" type="submit">Register</button>
                        </div>
                        <p class="text-center text-muted mt-3 mb-0">Have already an account? <a
                                href="{{ 'login' }}" class="fw-bold text-body"><u>Login here</u></a></p>
                    </form>
                </div>
            </div>

        </div>

    </section>
</div>
<script>
    function setImage(event){
        var preview = document.getElementById('preview');
        var image = URL.createObjectURL(event.target.files[0]);
        preview.src = image;
        preview.height = '200';
        preview.width="200"
    }
</script>

