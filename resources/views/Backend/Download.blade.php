@extends('Backend.Includes.Layout')

@section('content')

<div class="row">
    <div class="card-panel col s12 m6 l4 offset-m3 offset-l4">
        <div class="card-panel-title">
            <span class="right">
                <a href="#!"></a>
            </span>

            <div class="clearfix">&nbsp;</div>

            <h5>Download & Auth Key</h5>
        </div>
        <div class="card-panel-content col s12 m12">
            <div class="col s12">
                <p>Below you can find your authentication key and a link to download the latest plugin files. Installation instructions can be found here <a href="/Documentation/using-ADAM/installation/" target="_blank">Installation Instructions</a>.</p>

                <br>

                <p>Your Authentication Key is: &nbsp; {{ $CoreAuthKey['auth_key'] or 'No Authentication Key found. Please contact support.' }}</p>
                <p>You can download the plugin by <a href="/Plugin/ADAM.zip" target="_blank">Clicking Here</a>.</p>

                <div class="clearfix">&nbsp;</div>
            </div>
        </div>
    </div>
</div>

@endsection