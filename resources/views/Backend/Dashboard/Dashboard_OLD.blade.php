@extends('Backend.Includes.Layout')

@section('content')

<div class="card-panel-row row">
    <div class="col s12 m12">
        <div class="col s6 m2">
            <div class="card-panel col s12 z-depth-1">
                <span class="white-text flow-text center-align">
                    <h6>Experience Gained</h6>
                    <p id="experienceGained"></p>
                    <p class="super-small">Last 10 minutes</p>
                </span>
            </div>
        </div>

        <div class="col s6 m2">
            <div class="card-panel col s12 z-depth-1">
                <span class="white-text flow-text center-align">
                    <h6>Time Till Level</h6>
                    <p id="timeTillLevel"></p>
                    <p class="super-small">Estimate</p>
                </span>
            </div>
        </div>

        <div class="col s6 m2">
            <div class="card-panel col s12 z-depth-1">
                <span class="white-text flow-text center-align">
                    <h6>Items Gathered</h6>
                    <p id="itemsGatheredCount"></p>
                    <p class="super-small">---</p>
                </span>
            </div>
        </div>

        <div class="col s6 m2">
            <div class="card-panel col s12 z-depth-1">
                <span class="white-text flow-text center-align">
                    <h6>Items Crafted</h6>
                    <p id="itemsCraftedCount"></p>
                    <p class="super-small">---</p>
                </span>
            </div>
        </div>

        <div class="col s6 m2">
            <div class="card-panel col s12 z-depth-1">
                <span class="white-text flow-text center-align">
                    <h6>Free Bag Slots</h6>
                    <p id="freeBagSlots"></p>
                    <p class="super-small">---</p>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div id="ItemsGathered" class="col s12 m{{ isset($ParametersArray['ItemsGatheredWidth']) ? $ParametersArray['ItemsGatheredWidth'] : '6' }}">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!" onclick="$('#ItemsGathered-settings-modal').openModal();"><i class="material-icons">settings</i></a>
                </span>

                <h5>Items Gathered</h5>
            </div>

            <div class="card-panel-content col s12">
                <div id="ItemsGatheredList" style="height: {{ isset($ParametersArray['ItemsGatheredHeight']) ? $ParametersArray['ItemsGatheredHeight'] : '200' }}px;"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div id="ItemsCrafted" class="col s12 m{{ isset($ParametersArray['ItemsCraftedWidth']) ? $ParametersArray['ItemsCraftedWidth'] : '6' }}">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!" onclick="$('#ItemsCrafted-settings-modal').openModal();"><i class="material-icons">settings</i></a>
                </span>

                <h5>Items Crafted</h5>
            </div>

            <div class="card-panel-content col s12">
                <div id="ItemsCraftedList" style="height: {{ isset($ParametersArray['ItemsCraftedHeight']) ? $ParametersArray['ItemsCraftedHeight'] : '200' }}px;"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div id="ItemsSold" class="col s12 m{{ isset($ParametersArray['ItemsSoldWidth']) ? $ParametersArray['ItemsSoldWidth'] : '6' }}">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!" onclick="$('#ItemsSold-settings-modal').openModal();"><i class="material-icons">settings</i></a>
                </span>

                <h5>Items Sold</h5>
            </div>

            <div class="card-panel-content col s12">
                <div id="ItemsSoldList" style="height: {{ isset($ParametersArray['ItemsSoldHeight']) ? $ParametersArray['ItemsSoldHeight'] : '200' }}px;"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div id="load" style="display: none;"></div>
<div id="hiddenDiv" style="display: none;"></div>

<div id="ItemsGathered-settings-modal" class="modal">
    <div class="modal-content">
        <h5>Items Gathered Settings</h5>

        <div class="row">
            <h5>Items Gathered Height</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsGathered', '200');">200px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsGathered', '300');">300px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsGathered', '400');">400px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsGathered', '500');">500px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsGathered', '600');">600px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsGathered', '800');">800px</a>
        </div>

        <div class="row">
            <h5>Items Gathered Width</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsGathered', '2');">2</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsGathered', '4');">4</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsGathered', '6');">6</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsGathered', '8');">8</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsGathered', '10');">10</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsGathered', '12');">12</a>
        </div>

        <div class="row">
            <h5>Data Display Duration</h5>
            <p>How long data displays in this list.</p>
            <div id="ItemsGathered_Duration_Result"></div>
            <input id="ItemsGathered_Duration" type="number" min="1" max="24" class="validate" value="{{ $ItemsGatheredDuration['setting'] or '' }}" onchange="ElementControl.SetSetting('Dashboard', 'ItemsGathered', 'DisplayHours', $('#ItemsGathered_Duration').val());">
            <label for="ItemsGathered_Duration">Hours to Display Data</label>
        </div>
    </div>

    <div class="modal-footer">
        <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Save & Close</a>
    </div>
</div>

<div id="ItemsCrafted-settings-modal" class="modal">
    <div class="modal-content">
        <h5>Items Crafted Settings</h5>

        <div class="row">
            <h5>Items Crafted Height</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsCrafted', '200');">200px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsCrafted', '300');">300px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsCrafted', '400');">400px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsCrafted', '500');">500px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsCrafted', '600');">600px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsCrafted', '800');">800px</a>
        </div>

        <div class="row">
            <h5>Items Crafted Width</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsCrafted', '2');">2</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsCrafted', '4');">4</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsCrafted', '6');">6</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsCrafted', '8');">8</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsCrafted', '10');">10</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsCrafted', '12');">12</a>
        </div>

        <div class="row">
            <h5>Data Display Duration</h5>
            <p>How long data displays in this list.</p>
            <div id="ItemsCrafted_Duration_Result"></div>
            <input id="ItemsCrafted_Duration" type="number" min="1" max="24" class="validate" value="{{ $ItemsCraftedDuration['setting'] or '' }}" onchange="ElementControl.SetSetting('Dashboard', 'ItemsCrafted', 'DisplayHours', $('#ItemsCrafted_Duration').val());">
            <label for="ItemsCrafted_Duration">Hours to Display Data</label>
        </div>
    </div>

    <div class="modal-footer">
        <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Save & Close</a>
    </div>
</div>

<div id="ItemsSold-settings-modal" class="modal">
    <div class="modal-content">
        <h5>Items Sold Settings</h5>

        <div class="row">
            <h5>Items Sold Height</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsSold', '200');">200px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsSold', '300');">300px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsSold', '400');">400px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsSold', '500');">500px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsSold', '600');">600px</a>
            <a class="waves-effect btn" onclick="ElementControl.SetHeight('Dashboard', 'ItemsSold', '800');">800px</a>
        </div>

        <div class="row">
            <h5>Items Sold Width</h5>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsSold', '2');">2</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsSold', '4');">4</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsSold', '6');">6</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsSold', '8');">8</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsSold', '10');">10</a>
            <a class="waves-effect btn" onclick="ElementControl.SetWidth('Dashboard', 'ItemsSold', '12');">12</a>
        </div>

        <div class="row">
            <h5>Data Display Duration</h5>
            <p>How long data displays in this list.</p>
            <div id="ItemsSold_Duration_Result"></div>
            <input id="ItemsSold_Duration" type="number" min="1" max="24" class="validate" value="{{ $ItemsSoldDuration['setting'] or '' }}" onchange="ElementControl.SetSetting('Dashboard', 'ItemsSold', 'DisplayHours', $('#ItemsSold_Duration').val());">
            <label for="ItemsSold_Duration">Hours to Display Data</label>
        </div>
    </div>

    <div class="modal-footer">
        <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Save & Close</a>
    </div>
</div>

<script type="text/javascript">
    var Dashboard       = new Dashboard();
    var Helper          = new Helper();
    var ElementControl  = new ElementControl();

    $( document ).ready(function() {
        Dashboard.UpdateExperienceGained();
        Dashboard.UpdateTimeTillLevel();
        Dashboard.UpdateItemsGatheredCount();
        Dashboard.UpdateItemsCraftedCount();
        Dashboard.UpdateFreeBagSlots();

        Dashboard.UpdateItemsGatheredDiv();
        Dashboard.UpdateItemsCraftedDiv();
        Dashboard.UpdateItemsSoldDiv();

        setInterval("Dashboard.UpdateExperienceGained()", 60000);
        setInterval("Dashboard.UpdateTimeTillLevel()", 60000);
        setInterval("Dashboard.UpdateItemsGatheredCount()", 60000);
        setInterval("Dashboard.UpdateItemsCraftedCount()", 60000);
        setInterval("Dashboard.UpdateFreeBagSlots()", 60000);

        setInterval("Dashboard.UpdateItemsGatheredDiv()", 60000);
        setInterval("Dashboard.UpdateItemsCraftedDiv()", 60000);
        setInterval("Dashboard.UpdateItemsSoldDiv()", 60000);

        //setTimeout("Helper.ScrollDivInitial('#ItemsGatheredList')", 5000);
        //setTimeout("Helper.ScrollDivInitial('#ItemsCraftedList')", 5000);
        //setTimeout("Helper.ScrollDivInitial('#ItemsSoldList')", 5000);
    });
</script>

@endsection