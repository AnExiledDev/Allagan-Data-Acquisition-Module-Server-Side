@extends('Frontend.Includes.Layout')

@section('content')

<div class="row">
    <div class="col s12 m4 offset-m4">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Register an Account</h5>
            </div>

            <div class="card-panel-content col s12">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

                <form action="{{ route('RegisterCheck') }}" method="post">
                    {{ csrf_field() }}

                    <label>Please enter a valid email address:</label>
                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required />

                    <label>Please enter and verify your desired password:</label>
                    <input type="password" class="form-control" placeholder="Password" name="password" required />
                    <input type="password" class="form-control" placeholder="Verify Password" name="password_confirmation" required />

                    <button class="btn btn-default submit" type="submit">Create an Account</button>
                </form>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

@endsection