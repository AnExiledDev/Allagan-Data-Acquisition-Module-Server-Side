@extends('Backend.Includes.Layout')

@section('content')

<div class="grid-stack">

</div>

<script type="text/javascript">
    var options = {
        animate: true,
        alwaysShowResizeHandle: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
        resizable: {
            handles: 'e, se, s, sw, w'
        }
    };

    $('.grid-stack').gridstack(options);

    var grid = $('.grid-stack').data('gridstack');

    $( document ).ready(function() {
        @foreach ($UserWidgets as $UserWidget)
            @foreach ($Widgets as $Widget)
                @if ($Widget['id'] == $UserWidget['widget_id'] && $UserWidget['page_id'] == $PageID)
                    console.log("Adding Widget: {{ $Widget['name'] }} x: {{ $UserWidget['x_position'] }} y: {{ $UserWidget['y_position'] }} width: {{ $UserWidget['width'] }} height: {{ $UserWidget['height'] }}");
                    $.get('/Widget/{{ str_replace(' ', '', $Widget['name']) }}/{{ $PageID }}', function (data) {
                        $('main').append(data);
                        grid.addWidget($('#{{ str_replace(' ', '', $Widget['name']) }}Widget'), {{ $UserWidget['x_position'] }}, {{ $UserWidget['y_position'] }}, {{ $UserWidget['width'] }}, {{ $UserWidget['height'] }}, true);
                    });
                @endif
            @endforeach
        @endforeach

        setTimeout("MoveAndResizeWidgets()", 1000);
        setTimeout("InitiateGridStackChangeEvent()", 2000);
    });

    function AdjustElementHeights()
    {
        $("#chat-tabs").height($("#ChatWidget").innerHeight() - 160);
        $("#chat-content .tabs-pane").height($("#ChatWidget").innerHeight() - 160);
    }

    function AdjustElementSettings(widget, x, y, width, height)
    {
        $.get('/Widget/UpdateWidgetSettings/{{ $PageID }}/' + widget + '/' + x + '/' + y + '/' + width + '/' + height, function(data){ });
    }

    function MoveAndResizeWidgets()
    {
        var grid = $('.grid-stack').data('gridstack');

        @foreach ($UserWidgets as $UserWidget)
            @foreach ($Widgets as $Widget)
                @if ($Widget['id'] == $UserWidget['widget_id'] && $UserWidget['page_id'] == $PageID)
                    grid.move($('#{{ str_replace(' ', '', $Widget['name']) }}Widget'), {{ $UserWidget['x_position'] }}, {{ $UserWidget['y_position'] }});
                    grid.resize($('#{{ str_replace(' ', '', $Widget['name']) }}Widget'), {{ $UserWidget['width'] }}, {{ $UserWidget['height'] }});
                @endif
            @endforeach
        @endforeach

        setTimeout("AdjustElementHeights()", 1000);
    }

    function InitiateGridStackChangeEvent()
    {
        $('.grid-stack').on('change', function(event, items) {
            for (i = 0; i < items.length; i++)
            {
                AdjustElementSettings(items[i].el[0].id, items[i].x, items[i].y, items[i].width, items[i].height);
            }

            setTimeout("AdjustElementHeights()", 2000);
        });
    }
</script>

@endsection