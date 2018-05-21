function ElementControl()
{
    this.SetHeight = function(page, element, height)
    {
        if (element == "Chat")
        {
            $("#chat-tabs").height(height - 30);
            $("#chat-content").height(height - 30);
            $("#chat-content .tabs-pane").height(height - 30);
        }
        else if (element == "ItemsGathered")
        {
            $("#ItemsGatheredList").height(height);
        }
        else if (element == "ItemsCrafted")
        {
            $("#ItemsCraftedList").height(height);
        }
        else
        {
            $("#" + element + " div:first").height(height - 30);
        }

        $("#hiddenDiv").load("/Dashboard/UpdateElementSettings", { "Page": page, "Element": element, "Type": "Height", "Setting": height });
    };

    this.SetWidth = function(page, element, width)
    {
        $("#" + element).removeClass().addClass('col s12 m' + width);

        $("#hiddenDiv").load("/Dashboard/UpdateElementSettings", { "Page": page, "Element": element, "Type": "Width", "Setting": width });
    };

    this.SetSetting = function(page, element, type, setting)
    {
        $("#hiddenDiv").load("/Dashboard/UpdateSetting", { "Page": page, "Element": element, "Type": type, "Setting": setting });
    };
}