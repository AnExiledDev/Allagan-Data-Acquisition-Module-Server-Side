
<div id="ExperienceGainedWidget">
    <!-- Experience Gained Widget -- Content -->
    <div class="grid-stack-item-content">
        <div class="card-panel">
            <div class="card-panel-content">
                <div id="ExperienceGained" class="full-height"></div>
            </div>
        </div>
    </div>
    <!-- Experience Gained Widget -- Content -->

    <!-- Experience Gained Widget -- Settings Modal -->

    <!-- Experience Gained Widget -- Settings Modal -->

    <!-- Experience Gained Widget -- Javascript -->
    <script type="text/javascript">
        $( document ).ready(function() {
            UpdateExperienceGained();
            setInterval("UpdateExperienceGained()", 60000);
        });

        function UpdateExperienceGained()
        {
            $('#ExperienceGained').load("/Widget/ExperienceGained/{{ $PageID }}/Content");
        }
    </script>
    <!-- Experience Gained Widget -- Javascript -->
</div>
