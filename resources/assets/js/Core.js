function Core()
{
    this.socketConnectionStatusDiv = $('#socketConnectionStatus');
    this.currentCharacterInfoDiv = $('#currentCharacterInfo');
    this.dataQueueStatusDiv = $('#dataQueueStatus');

    this.UpdateSocketConnectionStatus = function()
    {
        Core.socketConnectionStatusDiv.load("/Footer/CheckSocketConnection");
    };

    this.UpdateDataQueueStatus = function()
    {
        Core.dataQueueStatusDiv.load("/Footer/CheckDataQueueStatus");
    };

    this.UpdateCurrentCharacterInfo = function()
    {
        Core.currentCharacterInfoDiv.load("/Footer/UpdateCurrentCharacterInfo");
    };

    this.SendNotification = function(title, message)
    {
        if (document.hasFocus() == false) {
            document.getElementById('notificationPing').play();
            OneSignal.sendSelfNotification(title, message);
        }
    };
}