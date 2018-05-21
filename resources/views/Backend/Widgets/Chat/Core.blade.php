
<div id="ChatWidget">
    <!-- Chat Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <!--<a href="#!" onclick="$('#Chat-settings-modal').modal('open');"><i class="fa fa-cog material-icons"></i></a>-->
                </span>

                <h5>Chat</h5>
            </div>
            <!-- $("#ChatWidget").innerHeight();-->
            <div class="card-panel-content">
                <div class="row">
                    <div id="chat-tabs" data-tabs class="col l3 hide-on-med-and-down">
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

                    <div id="chat-content" data-tabs-content class="col s12 m12 l9">
                        <div data-tabs-pane class="tabs-pane active" id="all"></div>
                        <div data-tabs-pane class="tabs-pane" id="action"></div>
                        <div data-tabs-pane class="tabs-pane" id="buddy"></div>
                        <div data-tabs-pane class="tabs-pane" id="sayyellshout"></div>
                        <div data-tabs-pane class="tabs-pane" id="novicenetwork"></div>
                        <div data-tabs-pane class="tabs-pane" id="tell"></div>
                        <div data-tabs-pane class="tabs-pane" id="freecompany"></div>
                        <div data-tabs-pane class="tabs-pane" id="party"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshells"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell1"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell2"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell3"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell4"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell5"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell6"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell7"></div>
                        <div data-tabs-pane class="tabs-pane" id="linkshell8"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m3">
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

                    <div class="input-field col s12 m7">
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

    <div id="load" style="display: none;"></div>
    <div id="sendChatResult" style="display: none;"></div>
    <div id="hiddenDiv" style="display: none;"></div>
    <!-- Chat Widget -- Content -->

    <!-- Chat Widget -- Settings Modal -->
    <div id="Chat-settings-modal" class="modal">
        <div class="modal-content">
            <h5>Chat Settings</h5>

            <div class="row">

            </div>
        </div>

        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Save & Close</a>
        </div>
    </div>
    <!-- Chat Widget -- Settings Modal -->

    <!-- Chat Widget -- Javascript -->
    <script type="text/javascript">
    var Dashboard       = new Dashboard();
    var Chat            = new ChatHelper();
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

    function ChatHelper()
    {
        this.Helper = new Helper();

        this.allTabContentDiv           = $('#all');
        this.actionTabContentDiv        = $('#action');
        this.sayYellShoutTabContentDiv  = $('#sayyellshout');
        this.noviceNetworkTabContentDiv = $('#novicenetwork');
        this.tellTabContentDiv          = $('#tell');
        this.freeCompanyTabContentDiv   = $('#freecompany');
        this.partyTabContentDiv         = $('#party');
        this.linkshellsTabContentDiv    = $('#linkshells');
        this.linkshell1TabContentDiv    = $('#linkshell1');
        this.linkshell2TabContentDiv    = $('#linkshell2');
        this.linkshell3TabContentDiv    = $('#linkshell3');
        this.linkshell4TabContentDiv    = $('#linkshell4');
        this.linkshell5TabContentDiv    = $('#linkshell5');
        this.linkshell6TabContentDiv    = $('#linkshell6');
        this.linkshell7TabContentDiv    = $('#linkshell7');
        this.linkshell8TabContentDiv    = $('#linkshell8');
        this.buddyTabContentDiv         = $('#buddy');

        this.sayYellShoutChannelSelect  = $('#sayYellShoutChannelSelect');
        this.noviceNetworkChannelSelect = $('#noviceNetworkChannelSelect');
        this.tellsChannelSelect         = $('#tellsChannelSelect');
        this.freeCompanyChannelSelect   = $('#freeCompanyChannelSelect');
        this.partyChannelSelect         = $('#partyChannelSelect');
        this.linkshell1ChannelSelect    = $('#linkshell1ChannelSelect');
        this.linkshell2ChannelSelect    = $('#linkshell2ChannelSelect');
        this.linkshell3ChannelSelect    = $('#linkshell3ChannelSelect');
        this.linkshell4ChannelSelect    = $('#linkshell4ChannelSelect');
        this.linkshell5ChannelSelect    = $('#linkshell5ChannelSelect');
        this.linkshell6ChannelSelect    = $('#linkshell6ChannelSelect');
        this.linkshell7ChannelSelect    = $('#linkshell7ChannelSelect');
        this.linkshell8ChannelSelect    = $('#linkshell8ChannelSelect');

        this.sendChatResultDiv          = $('#sendChatResult');
        this.chatMessageInput           = $('#chatMessage');
        this.chatChannelSelector        = $('#channelSelector');

        this.unreadSayYellShout = 0;
        this.unreadNoviceNetwork= 0;
        this.unreadTells        = 0;
        this.unreadFreeCompany  = 0;
        this.unreadParty        = 0;
        this.unreadLinkshell1   = 0;
        this.unreadLinkshell2   = 0;
        this.unreadLinkshell3   = 0;
        this.unreadLinkshell4   = 0;
        this.unreadLinkshell5   = 0;
        this.unreadLinkshell6   = 0;
        this.unreadLinkshell7   = 0;
        this.unreadLinkshell8   = 0;

        this.temporaryLoadDiv = $('#load');

        this.currentChannel = "/s";
        this.currentTab     = "All Chat";

        this.GetChat = function()
        {
            var lastChatID = $("#lastChatID").text();
            var lastActionID = $("#lastActionID").text();
            var lastBuddyID = $("#lastBuddyID").text();

            if (lastChatID == "") { lastChatID = 0; }
            if (lastActionID == "") { lastActionID = 0; }
            if (lastBuddyID == "") { lastBuddyID = 0; }

            this.temporaryLoadDiv.load("/Dashboard/GetChat/" + lastChatID + "/" + lastActionID + "/" + lastBuddyID);

            Chat.ScrollAllChatDivs();

            /** Get Chat Messages */
            $(
                "#load .chat"
            ).clone().appendTo(Chat.allTabContentDiv);

            /** Get Action Messages */
            $(
                "#load .actionText"
            ).clone().appendTo(Chat.actionTabContentDiv);

            /** Get Buddy Log Messages */
            $(
                "#load .buddyText"
            ).clone().appendTo(Chat.buddyTabContentDiv);

            /** Get All Linkshell Messages */
            $(
                "#load .chat-Linkshell1" +
                "#load .chat-Linkshell2" +
                "#load .chat-Linkshell3" +
                "#load .chat-Linkshell4" +
                "#load .chat-Linkshell5" +
                "#load .chat-Linkshell6" +
                "#load .chat-Linkshell7" +
                "#load .chat-Linkshell8"
            ).clone().appendTo(Chat.linkshellsTabContentDiv);

            /** Get Novice Network Messages */
            Chat.unreadNoviceNetwork += $(
                "#load .chat-NoviceNetwork"
            ).length;

            $(
                "#load .chat-NoviceNetwork"
            ).clone().appendTo(Chat.noviceNetworkTabContentDiv);

            /** Get Say, Yell and Shout Messages */
            Chat.unreadSayYellShout += $(
                "#load .chat-Say, " +
                "#load .chat-Yell, " +
                "#load .chat-Shout, " +
                "#load .chat-CustomEmotes, " +
                "#load .chat-StandardEmotes"
            ).length;

            $(
                "#load .chat-Say, " +
                "#load .chat-Yell, " +
                "#load .chat-Shout, " +
                "#load .chat-CustomEmotes, " +
                "#load .chat-StandardEmotes"
            ).clone().appendTo(Chat.sayYellShoutTabContentDiv);

            /** Get Tell Messages */
            Chat.unreadTells += $(
                "#load .chat-Tell, " +
                "#load .chat-Tell_Receive, " +
                "#load .chat-GM_Tell"
            ).length;

            $(
                "#load .chat-Tell, " +
                "#load .chat-Tell_Receive, " +
                "#load .chat-GM_Tell"
            ).clone().appendTo(Chat.tellTabContentDiv);

            /** Get Free Company Messages */
             Chat.unreadFreeCompany += $(
                "#load .chat-FreeCompany"
            ).length;

            $(
                "#load .chat-FreeCompany"
            ).clone().appendTo(Chat.freeCompanyTabContentDiv);

            /** Get Party Messages */
            Chat.unreadParty += $(
                "#load .chat-Party"
            ).length;

            $(
                "#load .chat-Party"
            ).clone().appendTo(Chat.partyTabContentDiv);

            /** Get Linkshell 1 Messages */
            Chat.unreadLinkshell1 += $(
                "#load .chat-Linkshell1"
            ).length;

            $(
                "#load .chat-Linkshell1"
            ).clone().appendTo(Chat.linkshell1TabContentDiv);

            /** Get Linkshell 2 Messages */
            Chat.unreadLinkshell2 += $(
                "#load .chat-Linkshell2"
            ).length;

            $(
                "#load .chat-Linkshell2"
            ).clone().appendTo(Chat.linkshell2TabContentDiv);

            /** Get Linkshell 3 Messages */
            this.unreadLinkshell3 += $(
                "#load .chat-Linkshell3"
            ).length;

            $(
                "#load .chat-Linkshell3"
            ).clone().appendTo(this.linkshell3TabContentDiv);

            /** Get Linkshell 4 Messages */
            Chat.unreadLinkshell4 += $(
                "#load .chat-Linkshell4"
            ).length;

            $(
                "#load .chat-Linkshell4"
            ).clone().appendTo(Chat.linkshell4TabContentDiv);

            /** Get Linkshell 5 Messages */
            Chat.unreadLinkshell5 += $(
                "#load .chat-Linkshell5"
            ).length;

            $(
                "#load .chat-Linkshell5"
            ).clone().appendTo(Chat.linkshell5TabContentDiv);

            /** Get Linkshell 6 Messages */
            Chat.unreadLinkshell6 += $(
                "#load .chat-Linkshell6"
            ).length;

            $(
                "#load .chat-Linkshell6"
            ).clone().appendTo(Chat.linkshell6TabContentDiv);

            /** Get Linkshell 7 Messages */
            Chat.unreadLinkshell7 += $(
                "#load .chat-Linkshell7"
            ).length;

            $(
                "#load .chat-Linkshell7"
            ).clone().appendTo(Chat.linkshell7TabContentDiv);

            /** Get Linkshell 8 Messages */
            Chat.unreadLinkshell8 += $(
                "#load .chat-Linkshell8"
            ).length;

            $(
                "#load .chat-Linkshell8"
            ).clone().appendTo(Chat.linkshell8TabContentDiv);

            Chat.SetTabsAsUnread();
            Chat.ScrollAllChatDivs();
        };

        this.SendChat = function()
        {
            Chat.sendChatResultDiv.load("/Dashboard/SendChat", { channel: Chat.currentChannel, chatMessage: Chat.chatMessageInput.val(), csrftoken: $('input[name="csrf-token"]').val() });

            if (Chat.channel == "/tell")
            {
                var splitChatMessage = Chat.chatMessageInput.val().split(" ", 2);
                Chat.chatMessageInput.val(splitChatMessage[0] + " " + splitChatMessage[1] + " ");
            }
            else
            {
                Chat.chatMessageInput.val("");
            }
        };

        this.ScrollAllChatDivs = function()
        {
            Chat.Helper.ScrollDiv("#all");
            Chat.Helper.ScrollDiv("#action");
            Chat.Helper.ScrollDiv("#sayyellshout");
            Chat.Helper.ScrollDiv("#novicenetwork");
            Chat.Helper.ScrollDiv("#tell");
            Chat.Helper.ScrollDiv("#freecompany");
            Chat.Helper.ScrollDiv("#party");
            Chat.Helper.ScrollDiv("#linkshells");
            Chat.Helper.ScrollDiv("#linkshell1");
            Chat.Helper.ScrollDiv("#linkshell2");
            Chat.Helper.ScrollDiv("#linkshell3");
            Chat.Helper.ScrollDiv("#linkshell4");
            Chat.Helper.ScrollDiv("#linkshell5");
            Chat.Helper.ScrollDiv("#linkshell6");
            Chat.Helper.ScrollDiv("#linkshell7");
            Chat.Helper.ScrollDiv("#linkshell8");
            Chat.Helper.ScrollDiv("#buddy");
        };

        this.ScrollAllChatDivsInitial = function()
        {
            Chat.Helper.ScrollDivInitial("#all");
            Chat.Helper.ScrollDivInitial("#action");
            Chat.Helper.ScrollDivInitial("#sayyellshout");
            Chat.Helper.ScrollDivInitial("#novicenetwork");
            Chat.Helper.ScrollDivInitial("#tell");
            Chat.Helper.ScrollDivInitial("#freecompany");
            Chat.Helper.ScrollDivInitial("#party");
            Chat.Helper.ScrollDivInitial("#linkshells");
            Chat.Helper.ScrollDivInitial("#linkshell1");
            Chat.Helper.ScrollDivInitial("#linkshell2");
            Chat.Helper.ScrollDivInitial("#linkshell3");
            Chat.Helper.ScrollDivInitial("#linkshell4");
            Chat.Helper.ScrollDivInitial("#linkshell5");
            Chat.Helper.ScrollDivInitial("#linkshell6");
            Chat.Helper.ScrollDivInitial("#linkshell7");
            Chat.Helper.ScrollDivInitial("#linkshell8");
            Chat.Helper.ScrollDivInitial("#buddy");
        };

        this.SetTabsAsUnread = function()
        {
            if (Chat.unreadSayYellShout > 0) { Chat.sayYellShoutChannelSelect.addClass('unread'); } else { Chat.sayYellShoutChannelSelect.removeClass('unread'); }
            if (Chat.unreadNoviceNetwork > 0) { Chat.noviceNetworkChannelSelect.addClass('unread'); } else { Chat.noviceNetworkChannelSelect.removeClass('unread'); }
            if (Chat.unreadTells > 0) { Chat.tellsChannelSelect.addClass('unread'); } else { Chat.tellsChannelSelect.removeClass('unread'); }
            if (Chat.unreadFreeCompany > 0) { Chat.freeCompanyChannelSelect.addClass('unread'); } else { Chat.freeCompanyChannelSelect.removeClass('unread'); }
            if (Chat.unreadParty > 0) { Chat.partyChannelSelect.addClass('unread'); } else { Chat.partyChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell1 > 0) { Chat.linkshell1ChannelSelect.addClass('unread'); } else { Chat.linkshell1ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell2 > 0) { Chat.linkshell2ChannelSelect.addClass('unread'); } else { Chat.linkshell2ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell3 > 0) { Chat.linkshell3ChannelSelect.addClass('unread'); } else { Chat.linkshell3ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell4 > 0) { Chat.linkshell4ChannelSelect.addClass('unread'); } else { Chat.linkshell4ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell5 > 0) { Chat.linkshell5ChannelSelect.addClass('unread'); } else { Chat.linkshell5ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell6 > 0) { Chat.linkshell6ChannelSelect.addClass('unread'); } else { Chat.linkshell6ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell7 > 0) { Chat.linkshell7ChannelSelect.addClass('unread'); } else { Chat.linkshell7ChannelSelect.removeClass('unread'); }
            if (Chat.unreadLinkshell8 > 0) { Chat.linkshell8ChannelSelect.addClass('unread'); } else { Chat.linkshell8ChannelSelect.removeClass('unread'); }
        };

        this.SetAllTabsAsRead = function()
        {
            Chat.unreadSayYellShout = 0;
            Chat.unreadNoviceNetwork= 0;
            Chat.unreadTells        = 0;
            Chat.unreadFreeCompany  = 0;
            Chat.unreadParty        = 0;
            Chat.unreadLinkshell1   = 0;
            Chat.unreadLinkshell2   = 0;
            Chat.unreadLinkshell3   = 0;
            Chat.unreadLinkshell4   = 0;
            Chat.unreadLinkshell5   = 0;
            Chat.unreadLinkshell6   = 0;
            Chat.unreadLinkshell7   = 0;
            Chat.unreadLinkshell8   = 0;
        };

        this.SetChannel = function(Channel)
        {
            Channel = Channel.split(' ', 2);

            Chat.currentChannel = Channel[0];
        };

        this.SetChannelByType = function(Channel)
        {
            var NewChannel = '/s';
            var NewChannelName = "/s (Say)";

            if (Channel == "Say") { NewChannel = '/s'; NewChannelName = '/s (Say)'; }
            if (Channel == "Shout") { NewChannel = '/sh'; NewChannelName = '/sh (Shout)'; }
            if (Channel == "Yell") { NewChannel = '/y'; NewChannelName = '/y (Yell)'; }
            if (Channel == "Tell") { NewChannel = '/tell'; NewChannelName = '/tell (Tell)'; }
            if (Channel == "Tell_Receive") { NewChannel = '/tell'; NewChannelName = '/tell (Tell)'; }
            if (Channel == "FreeCompany") { NewChannel = '/fc'; NewChannelName = '/fc (Free Company)'; }
            if (Channel == "Party") { NewChannel = '/p'; NewChannelName = '/p (Party)'; }
            if (Channel == "NoviceNetwork") { NewChannel = '/n'; NewChannelName = '/n (Novice Network)'; }
            if (Channel == "Linkshell1") { NewChannel = '/l1'; NewChannelName = '/l1 (LinkShell 1)'; }
            if (Channel == "Linkshell2") { NewChannel = '/l2'; NewChannelName = '/l2 (LinkShell 2)'; }
            if (Channel == "Linkshell3") { NewChannel = '/l3'; NewChannelName = '/l3 (LinkShell 3)'; }
            if (Channel == "Linkshell4") { NewChannel = '/l4'; NewChannelName = '/l4 (LinkShell 4)'; }
            if (Channel == "Linkshell5") { NewChannel = '/l5'; NewChannelName = '/l5 (LinkShell 5)'; }
            if (Channel == "Linkshell6") { NewChannel = '/l6'; NewChannelName = '/l6 (LinkShell 6)'; }
            if (Channel == "Linkshell7") { NewChannel = '/l7'; NewChannelName = '/l7 (LinkShell 7)'; }
            if (Channel == "Linkshell8") { NewChannel = '/l8'; NewChannelName = '/l8 (LinkShell 8)'; }

            Chat.currentChannel = NewChannel;
            Chat.chatChannelSelector.val(NewChannelName);
            Chat.chatMessageInput.val("");
        };

        this.SetTellUser = function(Name)
        {
            Chat.currentChannel = "/tell";
            Chat.chatMessageInput.val(Name + " ");

            Chat.chatChannelSelector.val("/tell (Tell)");

            Chat.chatMessageInput.focus();
            Chat.chatMessageInput[0].setSelectionRange(Chat.chatMessageInput.val().length * 2, Chat.chatMessageInput.val().length * 2)
        };

        this.SetTab = function(Tab)
        {
            Chat.currentTab = Tab;

            switch (Tab)
            {
                case 'All Chat':
                    tabby.toggleTab('#all');
                    break;
                case 'Action Log':
                    tabby.toggleTab('#action');
                    break;
                case 'Buddy Log':
                    tabby.toggleTab('#buddy');
                    break;
                case 'Say, Yell, Shout':
                    tabby.toggleTab('#sayyellshout');
                    break;
                case 'Novice Network':
                    tabby.toggleTab('#novicenetwork');
                    break;
                case 'Tells':
                    tabby.toggleTab('#tell');
                    break;
                case 'Free Company':
                    tabby.toggleTab('#freecompany');
                    break;
                case 'Party':
                    tabby.toggleTab('#party');
                    break;
                case 'All Linkshells':
                    tabby.toggleTab('#linkshells');
                    break;
                case 'Linkshell 1':
                    tabby.toggleTab('#linkshell1');
                    break;
                case 'Linkshell 2':
                    tabby.toggleTab('#linkshell2');
                    break;
                case 'Linkshell 3':
                    tabby.toggleTab('#linkshell3');
                    break;
                case 'Linkshell 4':
                    tabby.toggleTab('#linkshell4');
                    break;
                case 'Linkshell 5':
                    tabby.toggleTab('#linkshell5');
                    break;
                case 'Linkshell 6':
                    tabby.toggleTab('#linkshell6');
                    break;
                case 'Linkshell 7':
                    tabby.toggleTab('#linkshell7');
                    break;
                case 'Linkshell 8':
                    tabby.toggleTab('#linkshell8');
                    break;
            }
        };
    }
    </script>
    <script type="text/javascript">
        /*$( document ).ready(function() {
            UpdateItemsCraftedDiv();
            setInterval("UpdateItemsCraftedDiv()", 60000);
        });

        function UpdateItemsCraftedDiv()
        {
            $('#ItemsCraftedList').load("/Widget/ItemsCraftedList/0/Content");
        }*/
    </script>
    <!-- Chat Widget -- Javascript -->
</div>
