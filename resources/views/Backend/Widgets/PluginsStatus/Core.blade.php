
<div id="PluginsStatusWidget">
    <!-- Plugin Status Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-title">
                <h5>Plugin Status</h5>
            </div>

            <div class="card-panel-content">
                <div id="PluginsStatus" class="full-height"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div id="PluginsStatusWidget_Load" style="display: none;"></div>
    <!-- Plugin Status Widget -- Content -->

    <!-- Plugin Status Widget -- Settings Modal -->

    <!-- Plugin Status Widget -- Settings Modal -->

    <!-- Plugin Status Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdatePluginsStatus();
            setInterval("UpdatePluginsStatus()", 5000);
        });

        function UpdatePluginsStatus()
        {
            $('#PluginsStatus').load("/Widget/PluginsStatus/{{ $PageID }}/Content");
        }

        function EnableDisablePlugin(Plugin, Action)
        {
            $('#PluginsStatusWidget_Load').load("/Widget/PluginsStatus/EnableDisablePlugin/" + encodeURI(Plugin) + "/" + Action);
        }
    </script>
    <!-- Plugin Status Widget -- Javascript -->
</div>
