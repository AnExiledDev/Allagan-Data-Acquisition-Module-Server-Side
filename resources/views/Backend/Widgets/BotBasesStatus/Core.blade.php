
<div id="BotBasesStatusWidget">
    <!-- Bot Bases Status Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-title">
                <h5>BotBases Status</h5>
            </div>

            <div class="card-panel-content">
                <div id="BotBasesStatus" class="full-height"></div>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <div id="BotBasesStatusWidget_Load" style="display: none;"></div>
    <!-- Bot Bases Status Widget -- Content -->

    <!-- Bot Bases Status Widget -- Settings Modal -->

    <!-- Bot Bases Status Widget -- Settings Modal -->

    <!-- Bot Bases Status Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateBotBasesStatus();
            setInterval("UpdateBotBasesStatus()", 5000);
        });

        function UpdateBotBasesStatus()
        {
            $('#BotBasesStatus').load("/Widget/BotBasesStatus/0/Content");
        }

        function SelectBotBase(BotBase)
        {
            $('#BotBasesStatusWidget_Load').load("/Widget/BotBasesStatus/SelectBotBase/" + encodeURI(BotBase));
        }

        function SelectAndStartBotBase(BotBase)
        {
            $('#BotBasesStatusWidget_Load').load("/Widget/BotBasesStatus/SelectAndStartBotBase/" + encodeURI(BotBase));
        }
    </script>
    <!-- Bot Bases Status Widget -- Javascript -->
</div>
