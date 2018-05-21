
<div id="ItemsGatheredWidget">
    <!-- Items Gathered Count Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-content">
                <div id="ItemsGatheredCount" class="full-height"></div>
            </div>
        </div>
    </div>
    <!-- Items Gathered Count Widget -- Content -->

    <!-- Items Gathered Count Widget -- Settings Modal -->

    <!-- Items Gathered Count Widget -- Settings Modal -->

    <!-- Items Gathered Count Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateItemsGatheredCount();
            setInterval("UpdateItemsGatheredCount()", 60000);
        });

        function UpdateItemsGatheredCount()
        {
            $('#ItemsGatheredCount').load("/Widget/ItemsGathered/{{ $PageID }}/Content");
        }
    </script>
    <!-- Items Gathered Count Widget -- Javascript -->
</div>