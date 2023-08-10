@include('layouts.header')

<div class="container h-100 design">
    <section>

        <div class="row">

            <div class="col-md-6">

                <div class="form-reset-password">

                    {{-- @if (session()->has('msg'))
                        <div class="alert alert-success">
                            {{ session()->get('msg') }}
                        </div>
                    @endif --}}

                    <form action="{{ 'reset-password-confirm' }}" method="post" enctype="multipart/form-data" id="Login_form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h2 class="text-center mt-2">choose New Password</h2>
                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="old_password">Enter old password</label>
                                    <span class="error">*</span>
                                    <input type="password" name="old_password" id="old_password" class="form-control"
                                        value="{{ old('old_password') }}" />
                                    @error('old_password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="new_password">Enter new password</label>
                                    <span class="error">*</span>
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        value="{{ old('new_password') }}" />
                                    @error('new_password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="form-outline">
                                    <label class="form-label" for="confirm_password">Enter confirm password</label>
                                    <span class="error">*</span>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                        value="{{ old('confirm_password') }}" />
                                    @error('confirm_password')
                                        <div class="error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="pt-3 d-flex justify-content-center">
                            <button class="btn btn-lg btn-dark" name="save" type="submit">save</button>
                        </div>
                        <p class="text-center text-muted mt-3 mb-0"><a
                                href="{{ 'login' }}" class="fw-bold text-body"><u>Back</u></a></p>
                    </form>
                </div>
            </div>

        </div>

    </section>
</div>

