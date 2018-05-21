
<div id="TimeTillLevelWidget">
    <!-- Time Till Level Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-content">
                <div id="TimeTillLevel" class="full-height"></div>
            </div>
        </div>
    </div>
    <!-- Time Till Level Widget -- Content -->

    <!-- Time Till Level Widget -- Settings Modal -->

    <!-- Time Till Level Widget -- Settings Modal -->

    <!-- Time Till Level Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateTimeTillLevel();
            setInterval("UpdateTimeTillLevel()", 60000);
        });

        function UpdateTimeTillLevel()
        {
            $('#TimeTillLevel').load("/Widget/TimeTillLevel/{{ $PageID }}/Content");
        }
    </script>
    <!-- Time Till Level Widget -- Javascript -->
</div>