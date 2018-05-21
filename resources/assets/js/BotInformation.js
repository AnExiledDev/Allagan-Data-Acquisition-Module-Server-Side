function BotInformation()
{
    this.LoadDiv = $('#Load');
    this.BotStatusDiv = $('#BotStatus');
    this.BotBasesDiv = $('#BotBases');
    this.PluginsDiv = $('#Plugins');

    this.UpdateStatus = function()
    {
        BotInformation.BotStatusDiv.load("/BotInfo/BotStatus");
    };

    this.UpdateBotBases = function()
    {
        BotInformation.BotBasesDiv.load("/BotInfo/BotBases");
    };

    this.UpdatePlugins = function()
    {
        BotInformation.PluginsDiv.load("/BotInfo/Plugins");
    };

    this.StartStopBotBase = function()
    {
        BotInformation.LoadDiv.load("/BotInfo/StartStopBotBase");
    };

    this.SelectBotBase = function(BotBase)
    {
        BotInformation.LoadDiv.load("/BotInfo/SelectBotBase/" + encodeURI(BotBase));
    };

    this.SelectAndStartBotBase = function(BotBase)
    {
        BotInformation.LoadDiv.load("/BotInfo/SelectAndStartBotBase/" + encodeURI(BotBase));
    };

    this.EnableDisablePlugin = function(Plugin, Action)
    {
        BotInformation.LoadDiv.load("/BotInfo/EnableDisablePlugin/" + encodeURI(Plugin) + "/" + Action);
    };
}