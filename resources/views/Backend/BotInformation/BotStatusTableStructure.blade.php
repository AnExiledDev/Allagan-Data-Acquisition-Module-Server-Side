<table class="col s12 m12 l6">
    <tr>
        <td>BotBase Running:</td>
        <td>@if ($IsBotBaseRunning == true) Running @else Stopped @endif</td>
    </tr>
    <tr>
        <td>Selected BotBase:</td>
        <td>{{ $SelectedBotBase or 'Unknown' }}</td>
    </tr>
    <tr>
        <td colspan="2"><a class="waves-effect waves-light btn" onclick="BotInformation.StartStopBotBase(); return false;">Start / Stop</a></td>
    </tr>
</table>