function Helper()
{
    this.ScrollDivInitial = function(div)
    {
        $(div).scrollTop($(div).prop("scrollHeight"));
    };

    this.ScrollDiv = function(div)
    {
        // ($(div).prop("scrollHeight") - $(div).scrollTop()) - $(div).height() < 100 &&
        if (!$(div + ":hover").length)
        {
            $(div).scrollTop($(div).prop("scrollHeight"));
        }
    };
}