    </main>

    <div class="clearfix"></div>

    <footer class="page-footer footer-fixed z-depth-2">
        <div class="row">
            <div class="col m4 s12 white-text" style="text-align: center;">
                <span class="heavy-bold">Plugin </span>
                <span id="socketConnectionStatus"></span>
            </div>
            <div class="col m4 s12 white-text" style="text-align: center;">
                <span id="currentCharacterInfo"></span>
            </div>
            <div class="col m4 s12 hide-on-small-only white-text" style="text-align: center;">
                <span class="heavy-bold">Queue </span>
                <span id="dataQueueStatus"></span>
            </div>
        </div>
    </footer>

    <div id="Character-Select-modal" class="modal">
        <div class="modal-content">
            <h5>Select Your Character</h5>

            <div class="row">
                <p>Please select the character you would like to switch to.</p>

                <table class="striped responsive-table">
                    <tr>
                        <th>Character Name</th>
                        <th>Current Class</th>
                        <th>Free Bag Slots</th>
                        <th>Is Connected</th>
                        <th>Select</th>
                    </tr>
                    @foreach ($characters as $characterInfo)
                        <tr>
                            <td>{{ $characterInfo['player_name'] }}</td>
                            <td>{{ $characterInfo['current_job'] }}</td>
                            <td>{{ $characterInfo['free_inventory_slots'] }}</td>
                            <td>
                                @if (count($connectedCharacters) == 0)
                                    <strong style='color: #ff5019;'>Disconnected</strong>
                                @else
                                    @foreach ($connectedCharacters as $connectedCharacter)
                                        @if ($connectedCharacter['player_name'] == $characterInfo['player_name'])
                                            <strong style='color: #ed6d1a;'>Connected</strong>
                                            @break
                                            @break
                                        @else
                                            <strong style='color: #ff5019;'>Disconnected</strong>
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td><a class="waves-effect btn" href="{{ route('Dashboard-SwitchCharacters', ['character' => $characterInfo['id']]) }}">Select</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Close</a>
        </div>
    </div>

    <div id="Pages-settings-modal" class="modal">
        <div class="modal-content">
            <h5>Pages</h5>

            <div class="row">
                <p>You will need to refresh the current page for your new pages to display in the sidebar.</p>
                <p>For the page icon you will need to use an icon from <a href="http://fontawesome.io/icons/" target="_blank">Font-Awesome</a>. Insert the icon name without the "fa". For example if you want the tachometer icon you would enter "tachometer" not "fa-tachometer".</p>

                <table class="striped responsive-table" id="pages-table">
                    <tr>
                        <th>Page Name</th>
                        <th>Page Icon</th>
                        <th>Options</th>
                    </tr>
                    <tr>
                        <th><input placeholder="Page Name" id="page_name" type="text"></th>
                        <th><input placeholder="Page Icon" id="page_icon" type="text"></th>
                        <th><a href="#" onclick="AddPage();">Add Page</a></th>
                    </tr>
                    @foreach ($UserPages as $UserPage)
                        <tr id="ModalPageID-{{ $UserPage['id'] }}">
                            <td><span class="editable" data-url="/Page/Update/Name/{{ $UserPage['id'] }}">{{ $UserPage['page_name'] }}</span></td>
                            <td><span class="editable" data-url="/Page/Update/Icon/{{ $UserPage['id'] }}">{{ $UserPage['page_icon'] }}</span></td>
                            <td><a href="#" onclick="DeletePage({{ $UserPage['id'] }});">Delete</a></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <script type="text/javascript">
            function AddPage()
            {
                $.post("/Page/Add", { PageName: $('#page_name').val(), PageIcon: $('#page_icon').val() }).done(function( data ) {
                    Materialize.toast('Page added! Reload your page to see the new page in the sidebar.', 10000);
                });
            }

            function DeletePage(pageid)
            {
                $.get('/Page/Delete/' + pageid, function(data)
                {
                    $('#ModalPageID-' + pageid).remove();
                });
            }
        </script>

        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Close</a>
        </div>
    </div>

    <div id="Widgets-settings-modal" class="modal">
        <div class="modal-content">
            <h5>Widgets</h5>

            <div class="row">
                <p>Select the widgets you would like to add to the current page.</p>

                <table class="striped responsive-table">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Options</th>
                    </tr>
                    @foreach ($Widgets as $Widget)
                        <tr>
                            <td>{{ $Widget['name'] }}</td>
                            <td>{{ $Widget['description'] }}</td>
                            <td>
                                @php ($WidgetExists = false)
                                @foreach ($UserWidgets as $UserWidget)
                                    @if ($Widget['id'] == $UserWidget['widget_id'] && $UserWidget['page_id'] == $PageID)
                                        @php ($WidgetExists = true)
                                    @endif
                                @endforeach

                                <span id="WidgetOptions-{{ $Widget['id'] }}">
                                    @if (isset($WidgetExists) && $WidgetExists == true)
                                        <a href="#" onclick="DeleteWidget('{{ str_replace(' ', '', $Widget['name']) }}', {{ $Widget['id'] }}, {{ $PageID }});">Delete</a>
                                    @else
                                        <a href="#" onclick="AddWidget('{{ str_replace(' ', '', $Widget['name']) }}', {{ $Widget['x_position'] }}, {{ $Widget['y_position'] }}, {{ $Widget['width'] }}, {{ $Widget['height'] }}, {{ $Widget['id'] }}, {{ $PageID }});">Add</a>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <script type="text/javascript">
            function DeleteWidget(widget_name, id, page)
            {
                $.get('/Widget/Delete/' + page + '/' + id, function(data)
                {
                    $('#WidgetOptions-' + id).html('Deleted');
                    grid.removeWidget($('#' + widget_name + 'Widget'));
                });
            }

            function AddWidget(widget_name, x_position, y_position, width, height, id, page)
            {
                $.get('/Widget/Add/' + page + '/' + id, function(data)
                {
                    $('#WidgetOptions-' + id).html('Added');

                    $.get('/Widget/' + widget_name + '/' + page, function (data) {
                        $('main').append(data);
                        grid.addWidget($('#' + widget_name + 'Widget'), x_position, y_position, width, height, true);
                    });
                });
            }
        </script>

        <div class="modal-footer">
            <a href="#!" class="btn modal-action modal-close waves-effect waves-light">Close</a>
        </div>
    </div>

    <audio src="/ping.mp3" id="notificationPing"></audio>

    <div id="subHidden" style="display: none;"></div>

    <div id="widgetStorage" style="display: none;"></div>

    <script type="text/javascript">
        var Core = new Core();

        $(".button-collapse").sideNav({
            draggable: true,
            onOpen: function(el) { $("#burger-bar").css('display', 'none') },
            onClose: function(el) { $("#burger-bar").css('display', 'inherit') }
        });

        $(".burger-bar").sideNav({
            draggable: false,
            menuWidth: 60
        });

        $( document ).ready(function() {
            tabby.init();
            $('.editable').jinplace();

            Core.UpdateSocketConnectionStatus();
            Core.UpdateDataQueueStatus();
            Core.UpdateCurrentCharacterInfo();

            setInterval("Core.UpdateSocketConnectionStatus()", 5000);
            setInterval("Core.UpdateDataQueueStatus()", 30000);
            setInterval("Core.UpdateCurrentCharacterInfo()", 60000);
        });
    </script>

    <script>
        var PlayerID = 0;
        OneSignal.push(function() {
            OneSignal.on('subscriptionChange', function(event) {
                OneSignal.getUserId(function(userID) {
                    PlayerID = userID;
                    $('#subHidden').load("/Notifications/SetPlayerID", { PlayerID: PlayerID });
                });

                OneSignal.isPushNotificationsEnabled(function(isEnabled) {
                    if (isEnabled)
                        $('#subHidden').load("/Notifications/SetEnabledStatus", { Enabled: 1, PlayerID: PlayerID });
                    else
                        $('#subHidden').load("/Notifications/SetEnabledStatus", { Enabled: 0, PlayerID: PlayerID });
                });
            });
        });
    </script>
</body>
</html>