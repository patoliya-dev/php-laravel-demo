@include('layouts.header')


<div class="container h-100">
    <section>
        <div class="row">
            <div class="col-md-6 emailDesign">
                <h4>Hello {{ $data->first_name }} </h4>
                <p> Your Are Successfully Registered </p>
                <p>We’d like to confirm that your account was created successfully. To access this app click the Button
                    below.</p>
                <a class="btn btn-primary mb-3" href="{{ env('APP_URL') . 'login' }}"> login </a>
                <p>Best,<br>
                    laravel-dev
                </p>
            </div>
        </div>
    </section>
</div>
<style>
    .emailDesign {
        padding: 30px;
        border: 1px solid black;
        margin: 50px;
    }
</style>
