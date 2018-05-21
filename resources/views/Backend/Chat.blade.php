@extends('Backend.Includes.Layout')

@section('content')

<div class="row">
    <div id="Chat" class="col s{{ $ParametersArray['ChatWidth'] or '12' }} m{{ $ParametersArray['ChatWidth'] or '12' }}">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!" onclick="$('#Chat-settings-modal').openModal();"><i class="material-icons">settings</i></a>
                </span>

                <h5>Chat</h5>
            </div>

            <div class="card-panel-content col s12">
                <div id="chat-tabs" data-tabs class="col l2 hide-on-med-and-down" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;">
                    <p class="chatChannelSelect">
                        <span><a id="allChannelSelect" class="active" data-tab href="#all">All Chat</a></span><br>
                        <span><a id="actionChannelSelect" data-tab href="#action">Action Log</a></span><br>
                        <span><a id="buddyChannelSelect" data-tab href="#buddy">Buddy Log</a></span><br>
                        <span><a id="sayYellShoutChannelSelect" data-tab href="#sayyellshout" onclick="Chat.unreadSayYellShout = 0;">Say, Yell, Shout</a></span><br>
                        <span><a id="noviceNetworkChannelSelect" data-tab href="#novicenetwork" onclick="Chat.unreadNoviceNetwork = 0;">Novice Network</a></span><br>
                        <span><a id="tellsChannelSelect" data-tab href="#tell" onclick="Chat.unreadTells = 0;">Tells</a></span><br>
                        <span><a id="freeCompanyChannelSelect" data-tab href="#freecompany" onclick="Chat.unreadFreeCompany = 0;">Free Company</a></span><br>
                        <span><a id="partyChannelSelect" data-tab href="#party" onclick="Chat.unreadParty = 0;">Party</a></span><br>
                        <span><a id="linkshellsChannelSelect" data-tab href="#linkshells">All Linkshells</a></span><br>
                        <span><a id="linkshell1ChannelSelect" data-tab href="#linkshell1" onclick="Chat.unreadLinkShell1 = 0;">Linkshell 1</a></span><br>
                        <span><a id="linkshell2ChannelSelect" data-tab href="#linkshell2" onclick="Chat.unreadLinkShell2 = 0;">Linkshell 2</a></span><br>
                        <span><a id="linkshell3ChannelSelect" data-tab href="#linkshell3" onclick="Chat.unreadLinkShell3 = 0;">Linkshell 3</a></span><br>
                        <span><a id="linkshell4ChannelSelect" data-tab href="#linkshell4" onclick="Chat.unreadLinkShell4 = 0;">Linkshell 4</a></span><br>
                        <span><a id="linkshell5ChannelSelect" data-tab href="#linkshell5" onclick="Chat.unreadLinkShell5 = 0;">Linkshell 5</a></span><br>
                        <span><a id="linkshell6ChannelSelect" data-tab href="#linkshell6" onclick="Chat.unreadLinkShell6 = 0;">Linkshell 6</a></span><br>
                        <span><a id="linkshell7ChannelSelect" data-tab href="#linkshell7" onclick="Chat.unreadLinkShell7 = 0;">Linkshell 7</a></span><br>
                        <span><a id="linkshell8ChannelSelect" data-tab href="#linkshell8" onclick="Chat.unreadLinkShell8 = 0;">Linkshell 8</a></span><br>
                    </p>
                </div>

                <div id="chat-tabs-small" data-tabs class="col s12 m12 hide-on-large-only">
                    <select class="browser-default chatChannelSelect">
                        <option data-tab selected>All Chat</option>
                        <option data-tab>Action Log</option>
                        <option data-tab>Buddy Log</option>
                        <option data-tab>Say, Yell, Shout</option>
                        <option data-tab>Novice Network</option>
                        <option data-tab>Tells</option>
                        <option data-tab>Free Company</option>
                        <option data-tab>Party</option>
                        <option data-tab>All Linkshells</option>
                        <option data-tab>Linkshell 1</option>
                        <option data-tab>Linkshell 2</option>
                        <option data-tab>Linkshell 3</option>
                        <option data-tab>Linkshell 4</option>
                        <option data-tab>Linkshell 5</option>
                        <option data-tab>Linkshell 6</option>
                        <option data-tab>Linkshell 7</option>
                        <option data-tab>Linkshell 8</option>
                    </select>

                    <div class="clearfix"></div>
                </div>

                <div id="chat-content" data-tabs-content class="col s12 m12 l10" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;">
                    <div data-tabs-pane class="tabs-pane active" id="all" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="action" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="buddy" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="sayyellshout" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="novicenetwork" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="tell" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="freecompany" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="party" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshells" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell1" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell2" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell3" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell4" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell5" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell6" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell7" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                    <div data-tabs-pane class="tabs-pane" id="linkshell8" style="height: {{ $ParametersArray['ChatHeight'] or '300' }}px;"></div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m2">
                        <select id="channelSelector" class="browser-default">
                            <option selected>/s (Say)</option>
                            <option>/sh (Shout)</option>
                            <option>/y (Yell)</option>
                            <option>/tell (Tell)</option>
                            <option>/r (Reply)</option>
                            <option>/em (Emote)</option>
                            <option>/fc (Free Company)</option>
                            <option>/p (Party)</option>
                            <option>/n (Novice Network)</option>
                            <option>/l1 (LinkShell 1)</option>
                            <option>/l2 (LinkShell 2)</option>
                            <option>/l3 (LinkShell 3)</option>
                            <option>/l4 (LinkShell 4)</option>
                            <option>/l5 (LinkShell 5)</option>
                            <option>/l6 (LinkShell 6)</option>
                            <option>/l7 (LinkShell 7)</option>
                            <option>/l8 (LinkShell 8)</option>
                            <option>/ (Any Command)</option>
                        </select>
                    </div>

                    <div class="input-field col s12 m8">
                        <form onsubmit="Chat.SendChat(); return false;" autocomplete="off"><input id="chatMessage" type="text" autocomplete="off"></form>

                        {{ csrf_field() }}
                    </div>

                    <div class="input-field col s12 m2 right">
                        <a class="waves-effect waves-light btn-large right" onclick="Chat.SendChat();">Send</a>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div id="load" style="display: none;"></div>
<div id="sendChatResult" style="display: none;"></div>
<div id="hiddenDiv" style="display: none;"></div>

<div id="Chat-settings-modal" class="modal">
    <div class="modal-content">
        <h5>Chat Settings</h5>

        <div class="row">
            <h5>Chat Height</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'Chat', '200');">200px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'Chat', '300');">300px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'Chat', '400');">400px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'Chat', '500');">500px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'Chat', '600');">600px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'Chat', '800');">800px</a>
        </div>

        <div class="row">
            <h5>Chat Width</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'Chat', '2');">2</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'Chat', '4');">4</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'Chat', '6');">6</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'Chat', '8');">8</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'Chat', '10');">10</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'Chat', '12');">12</a>
        </div>
    </div>

    <div class="modal-footer">
        <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Save & Close</a>
    </div>
</div>

<script type="text/javascript">
    var Dashboard       = new Dashboard();
    var Chat            = new Chat();
    var Helper          = new Helper();
    var ElementControl  = new ElementControl();

    $( document ).ready(function() {
        Chat.GetChat();
        setInterval("Chat.GetChat()", 1000);

        setTimeout("Chat.ScrollAllChatDivsInitial();", 5000);
        setTimeout("Chat.SetAllTabsAsRead();", 5000);

        $('.chatChannelSelect').on('change', function()
        {
            Chat.SetTab(this.value);
        });

        $(".chatChannelSelect a").click(function()
        {
            Chat.SetTab($(this).text());
        });

        $('#channelSelector').on('change', function()
        {
            Chat.SetChannel(this.value);
        });
    });
</script>

@endsection