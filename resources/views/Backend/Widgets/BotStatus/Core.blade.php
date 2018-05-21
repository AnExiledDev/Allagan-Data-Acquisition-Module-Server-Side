
<div id="BotStatusWidget">
    <!-- Bot Status Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-title">
                <h5>Bot Status</h5>
            </div>

            <div class="card-panel-content">
                <div id="BotStatus" class="full-height"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div id="BotStatusWidget_Load" style="display: none;"></div>
    <!-- Bot Status Widget -- Content -->

    <!-- Bot Status Widget -- Settings Modal -->

    <!-- Bot Status Widget -- Settings Modal -->

    <!-- Bot Status Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateBotStatus();
            setInterval("UpdateBotStatus()", 2000);
        });

        function UpdateBotStatus()
        {
            $('#BotStatus').load("/Widget/BotStatus/{{ $PageID }}/Content");
        }

        function StartStopBotBase()
        {
            $('#BotStatusWidget_Load').load("/Widget/BotStatus/StartStopBotBase");
        }
    </script>
    <!-- Bot Status Widget -- Javascript -->
</div>
