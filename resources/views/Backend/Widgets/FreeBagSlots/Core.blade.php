
<div id="FreeBagSlotsWidget">
    <!-- Items Crafted List Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-content">
                <div id="FreeBagSlots" class="full-height"></div>
            </div>
        </div>
    </div>
    <!-- Items Crafted List Widget -- Content -->

    <!-- Items Crafted List Widget -- Settings Modal -->

    <!-- Items Crafted List Widget -- Settings Modal -->

    <!-- Items Crafted List Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateFreeBagSlots();
            setInterval("UpdateFreeBagSlots()", 60000);
        });

        function UpdateFreeBagSlots()
        {
            $('#FreeBagSlots').load("/Widget/FreeBagSlots/{{ $PageID }}/Content");
        }
    </script>
    <!-- Items Crafted List Widget -- Javascript -->
</div>
