
<div id="ItemsCraftedWidget">
    <!-- Items Crafted Count Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-content">
                <div id="ItemsCraftedCount" class="full-height"></div>
            </div>
        </div>
    </div>
    <!-- Items Crafted Count Widget -- Content -->

    <!-- Items Crafted Count Widget -- Settings Modal -->

    <!-- Items Crafted Count Widget -- Settings Modal -->

    <!-- Items Crafted Count Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateItemsCraftedCount();
            setInterval("UpdateItemsCraftedCount()", 60000);
        });

        function UpdateItemsCraftedCount()
        {
            $('#ItemsCraftedCount').load("/Widget/ItemsCrafted/{{ $PageID }}/Content");
        }
    </script>
    <!-- Items Crafted Count Widget -- Javascript -->
</div>
