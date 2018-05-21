<!-- Bot Bases Status Widget -- Content -- Core -->
<table class="col s12">
    <tr>
        <th>BotBase Name</th>
        <th>Options</th>
    </tr>
    @foreach ($BotBases as $BotBase)
        <tr>
            <td>{{ $BotBase['Name'] }}</td>
            <td>
                <a class="waves-effect waves-light btn" onclick="SelectBotBase('{{ $BotBase['Name'] }}'); return false;">Select</a>
                <a class="waves-effect waves-light btn" onclick="SelectAndStartBotBase('{{ $BotBase['Name'] }}'); return false;">Select & Start</a>
            </td>
        </tr>
    @endforeach
</table>
<!-- Bot Bases Status Widget -- Content -- Core -->