function Chat()
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
    this.buddyChannelSelect         = $('#buddyChannelSelect');

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