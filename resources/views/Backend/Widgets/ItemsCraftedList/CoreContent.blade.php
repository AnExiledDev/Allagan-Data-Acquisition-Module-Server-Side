<!-- Items Crafted List Widget -- Content -- Core -->
<table class='striped'>
    <tr>
        <td class='col s4 m2 l1'>
            Amount
        </td>
        <td class='col s8 m10 l11'>
            Name
        </td>
    </tr>
        @foreach ($ItemsCrafted as $ItemCrafted)
            <tr>
                <td>
                    {{ $ItemCrafted['amount'] }}
                </td>
                <td>
                    <object data='{{ $ItemCrafted['image_url'] }}' type='image/png' style='height: 21px; border-radius: 3px; vertical-align: middle; margin-top: -2px;'></object>
                    <a href='https://xivdb.com/item/{{ $ItemCrafted['xivdb_id'] }}/' data-tooltip-id='item/{{ $ItemCrafted['xivdb_id'] }}' data-xivdb-seturlicon='0' target='_blank'>
                        {{ $ItemCrafted['name'] }}
                    </a>

                    @if ($ItemCrafted['isHighQuality'] == true)
                    &nbsp; <img src='./Images/Icons/HQ_icon.png' style="height: 18px; vertical-align: middle; margin-top: -2px;" />
                    @endif

                    @if ($ItemCrafted['isCollectable'] == true)
                    &nbsp; <img src='./Images/Icons/Collectable_icon.png' style="height: 18px; vertical-align: middle; margin-top: -2px;" />
                    @endif
                </td>
            </tr>
        @endforeach
</table>

<script type='text/javascript'>
    XIVDBTooltips.get();
</script>
<!-- Items Crafted List Widget -- Content -- Core -->