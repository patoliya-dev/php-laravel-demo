@include('layouts.header')


<div class="container h-100 design">
    <section>
        <div class="row">
            <div class="col-md-6">
                <h1>hello </h1>
                <h4>{{ $data->first_name }} </h4>
                <p> your password reset successfully </p>

                <a class="btn btn-primary" href="{{ env('APP_URL') . 'login' }}"> login </a>
            </div>
        </div>
    </section>
</div>