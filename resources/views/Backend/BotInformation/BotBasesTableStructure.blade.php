<table class="col s12 m12">
    <tr>
        <th>BotBase Name</th>
        <th>Options</th>
    </tr>
    @foreach ($BotBases as $BotBase)
        <tr>
            <td>{{ $BotBase['Name'] }}</td>
            <td>
                <a class="waves-effect waves-light btn" onclick="BotInformation.SelectBotBase('{{ $BotBase['Name'] }}'); return false;">Select</a>
                <a class="waves-effect waves-light btn" onclick="BotInformation.SelectAndStartBotBase('{{ $BotBase['Name'] }}'); return false;">Select & Start</a>
            </td>
        </tr>
    @endforeach
</table>