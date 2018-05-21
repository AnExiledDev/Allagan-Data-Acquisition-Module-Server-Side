
<div id="ItemsCraftedListWidget">
    <!-- Items Crafted List Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <!--<a href="#!" onclick="$('#ItemsCrafted-settings-modal').modal('open');"><i class="material-icons">settings</i></a>-->
                </span>

                <h5>Items Crafted</h5>
            </div>

            <div class="card-panel-content">
                <div id="ItemsCraftedList" class="full-height"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Items Crafted List Widget -- Content -->

    <!-- Items Crafted List Widget -- Settings Modal -->
    <div id="ItemsCrafted-settings-modal" class="modal">
        <div class="modal-content">
            <h4>Items Crafted Settings</h4>

            <div class="row">
                <h6>Data Display Duration</h6>
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
    <!-- Items Crafted List Widget -- Settings Modal -->

    <!-- Items Crafted List Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateItemsCraftedDiv();
            setInterval("UpdateItemsCraftedDiv()", 60000);
        });

        function UpdateItemsCraftedDiv()
        {
            $('#ItemsCraftedList').load("/Widget/ItemsCraftedList/{{ $PageID }}/Content");
        }
    </script>
    <!-- Items Crafted List Widget -- Javascript -->
</div>
