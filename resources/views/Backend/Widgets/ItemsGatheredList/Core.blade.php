
<div id="ItemsGatheredListWidget">
    <!-- Items Gathered List Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <!--<a href="#!" onclick="$('#ItemsGathered-settings-modal').modal('open');"><i class="material-icons">settings</i></a>-->
                </span>

                <h5>Items Gathered</h5>
            </div>

            <div class="card-panel-content">
                <div id="ItemsGatheredList" class="full-height"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Items Gathered List Widget -- Content -->

    <!-- Items Gathered List Widget -- Settings Modal -->
    <div id="ItemsGathered-settings-modal" class="modal">
        <div class="modal-content">
            <h4>Items Gathered Settings</h4>

            <div class="row">
                <h6>Data Display Duration</h6>
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
    <!-- Items Gathered List Widget -- Settings Modal -->

    <!-- Items Gathered List Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateItemsGatheredDiv();
            setInterval("UpdateItemsGatheredDiv()", 60000);
        });

        function UpdateItemsGatheredDiv()
        {
            $('#ItemsGatheredList').load("/Widget/ItemsGatheredList/{{ $PageID }}/Content");
        }
    </script>
    <!-- Items Gathered List Widget -- Javascript -->
</div>
