@extends('Backend.Includes.Layout')

@section('content')

<div class="row">
    <div class="col s12 m4">
        <div class="card-panel">
            <div class="card-panel-title">
                <h5>Bot Status</h5>
            </div>

            <div class="card-panel-content col s12" id="BotStatus"></div>

            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col s12 m4">
        <div class="card-panel">
            <div class="card-panel-title">
                <h5>Available Bot Bases</h5>
            </div>

            <div class="card-panel-content col s12" id="BotBases"></div>

            <div class="clearfix"></div>
        </div>
    </div>
    <div class="col s12 m4">
        <div class="card-panel">
            <div class="card-panel-title">
                <h5>Available Plugins</h5>
            </div>

            <div class="card-panel-content col s12" id="Plugins"></div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div id="Load" style="display: none;"></div>

<script type="text/javascript">
    var BotInformation = new BotInformation();

    $( document ).ready(function() {
        BotInformation.UpdateStatus();
        BotInformation.UpdateBotBases();
        BotInformation.UpdatePlugins();

        setInterval("BotInformation.UpdateStatus()", 2000);
        setInterval("BotInformation.UpdateBotBases()", 5000);
        setInterval("BotInformation.UpdatePlugins()", 5000);
    });
</script>

@endsection