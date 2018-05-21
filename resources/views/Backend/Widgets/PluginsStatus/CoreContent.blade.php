<!-- Plugin Status Widget -- Content -- Core -->
<table class="col s12">
    <tr>
        <th>Plugin Name</th>
        <th>Enabled</th>
        <th>Options</th>
    </tr>
    @foreach ($Plugins as $Plugin)
        <tr>
            <td>{{ $Plugin['Name'] }}</td>
            <td>@if ($Plugin['IsEnabled'] == true) <span class="light-blue-text lighten-5">Enabled</span> @else <span class="deep-orange-text lighten-1">Disabled</span> @endif</td>
            <td>
                @if ($Plugin['IsEnabled'] == true)
                    <a class="waves-effect waves-light btn " onclick="EnableDisablePlugin('{{ $Plugin['Name'] }}', 'Disable'); return false;">Disable</a>
                @else
                    <a class="waves-effect waves-light btn" onclick="EnableDisablePlugin('{{ $Plugin['Name'] }}', 'Enable'); return false;">Enable</a>
                @endif
            </td>
        </tr>
    @endforeach
</table>
<!-- Plugin Status Widget -- Content -- Core -->