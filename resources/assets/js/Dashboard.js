function Dashboard()
{
    this.Helper = new Helper();

    this.experienceValueDiv = $('#experienceGained');
    this.timeTillLevelDiv = $('#timeTillLevel');
    this.itemsGatheredCountDiv = $('#itemsGatheredCount');
    this.itemsCraftedCountDiv = $('#itemsCraftedCount');
    this.freeBagSlotsDiv = $('#freeBagSlots');
    this.itemsGatheredDiv = $('#ItemsGatheredList');
    this.itemsCraftedDiv = $('#ItemsCraftedList');
    this.itemsSoldDiv = $('#ItemsSoldList');

    this.UpdateExperienceGained = function()
    {
        Dashboard.experienceValueDiv.load("/Dashboard/ExperienceGained");
    };

    this.UpdateTimeTillLevel = function()
    {
        Dashboard.timeTillLevelDiv.load("/Dashboard/TimeTillLevelUp");
    };

    this.UpdateItemsGatheredCount = function()
    {
        Dashboard.itemsGatheredCountDiv.load("/Dashboard/ItemsGathered");
    };

    this.UpdateItemsCraftedCount = function()
    {
        Dashboard.itemsCraftedCountDiv.load("/Dashboard/ItemsCrafted");
    };

    this.UpdateFreeBagSlots = function()
    {
        Dashboard.freeBagSlotsDiv.load("/Dashboard/FreeBagSlots");
    };

    this.UpdateItemsGatheredDiv = function()
    {
        Dashboard.itemsGatheredDiv.load("/Dashboard/ItemsGatheredList");

        //Dashboard.Helper.ScrollDiv("#ItemsGatheredList");
    };

    this.UpdateItemsCraftedDiv = function()
    {
        Dashboard.itemsCraftedDiv.load("/Dashboard/ItemsCraftedList");

        //Dashboard.Helper.ScrollDiv("#ItemsCraftedList");
    };

    this.UpdateItemsSoldDiv = function()
    {
        Dashboard.itemsSoldDiv.load("/Dashboard/ItemsSoldList");

        //Dashboard.Helper.ScrollDiv("#ItemsSoldList");
    };
}