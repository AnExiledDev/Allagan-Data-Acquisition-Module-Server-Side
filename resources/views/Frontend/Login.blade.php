@extends('Frontend.Includes.Layout')

@section('content')

<div class="row">
    <div class="col s12 m4 offset-m4 center-align">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Login to ADAM</h5>
            </div>

            <div class="card-panel-content col s12">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

                <form action="{{ route('LoginAuthenticate') }}" method="post">
                    {{ csrf_field() }}

                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required />
                    <input type="password" class="form-control" placeholder="Password" name="password" required />
                    <button class="btn btn-default submit" type="submit">Log In</button>
                </form>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

@endsection