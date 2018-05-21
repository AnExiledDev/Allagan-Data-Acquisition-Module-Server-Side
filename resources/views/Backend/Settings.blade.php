@extends('Backend.Includes.Layout')

@section('content')

<div class="row">
    <div class="col s12 m6 l6 offset-m3 offset-l3">
        <ul class="tabs">
            <li class="tab"><a href="#overview">Overview</a></li>
            <li class="tab"><a href="#settings">Settings</a></li>
            <li class="tab"><a href="#update-email">Update Email</a></li>
            <li class="tab"><a href="#update-password">Update Password</a></li>
        </ul>
    </div>

    <div id="overview" class="col s12 m6 l6 offset-m3 offset-l3">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Account Overview</h5>
            </div>

            <div class="card-panel-content col s12">
                <table>
                    <tr>
                        <th>Your Email:</th>
                        <td>{{ $user['email'] }}</td>
                    </tr>
                    <tr>
                        <th>Latest Plugin Files:</th>
                        <td><a href="/Plugin/ADAM.zip" target="_blank">Download</a></td>
                    </tr>
                </table>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>

        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Keys</h5>
            </div>

            <div class="card-panel-content col s12">
                <p>You can see all of your active keys here.</p>
                <table>
                    <tr>
                        <th>Core Auth Key:</th>
                        <td>{{ $CoreAuthKey['auth_key'] or 'NA' }}</td>
                    </tr>
                </table>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>

        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Purge All Data</h5>
            </div>

            <div class="card-panel-content col s12">
                @if (Session::has('status'))
                    <p>{{ Session::get('status') }}</p><br>
                @endif
                <p>If you wish to purge all of your data, you can do so here. This will not delete your account, however it will delete your character, and all chat logs, action logs, combat logs, crafting logs, experience logs, and gathering logs. Everything relating to your presence in FFXIV will be removed. THIS IS NOT REVERSIBLE! The data will be unrecoverable! Please note, this process may take a while to complete.</p>
                <br>
                <a href="{{ route('Settings-PurgeAllData') }}" onclick="return confirm('Are you sure? You can not undo this action!');" type="button" class="btn btn-primary">Purge All Data</a>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>
    </div>

    <div id="settings" class="col s12 m6 l6 offset-m3 offset-l3">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>General Settings</h5>
            </div>

            <div class="card-panel-content col s12">
                @if (Session::has('status'))
                    <p>{{ Session::get('status') }}</p>
                @endif

                <form action="{{ route('Settings-SaveTimezone') }}" method="post">
                    <select name="timezone" class="browser-default">
                        @foreach ($timezones as $timezoneName => $timezoneOffset)
                            <option value="{{ $timezoneName }}" @if (isset($timezone['type']) && $timezoneName == $timezone['type']) selected="selected" @endif>
                                @if ($timezoneOffset > 0)
                                    (UTC +{{ $timezoneOffset }})
                                @else
                                    (UTC {{ $timezoneOffset }})
                                @endif

                                {{ $timezoneName }}
                            </option>
                        @endforeach
                    </select>

                    {{ csrf_field() }}

                    <button id="generalSettingsButton" type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>

        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Notification Settings</h5>
            </div>

            <div class="card-panel-content col s12">
                @if (Session::has('status'))
                    <p>{{ Session::get('status') }}</p>
                @endif

                <p>Here you can set your notification settings. These only work on Firefox and Chrome right now for Desktop + Mobile. To disable notifications you can either uncheck all of the below values, or unsubscribe from notifications by clicking the bell icon at the bottom right. (If no bell icon is displayed, your browser does not support notifications.)</p>
                <form action="{{ route('Settings-SaveNotifications') }}" method="post">
                    <table class="col s12 m6 l4">
                        <tr>
                            <td>All Chat</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="all_chat_notifications" name="all_chat_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "all" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="all_chat_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Say</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="say_notifications" name="say_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "say" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="say_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Yell</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="yell_notifications" name="yell_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "yell" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="yell_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Shout</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="shout_notifications" name="shout_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "shout" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="shout_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Novice Network</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="novice_network_notifications" name="novice_network_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "novice_network" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="novice_network_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Tells</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="tells_notifications" name="tells_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "tells" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="tells_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Free Company</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="free_company_notifications" name="free_company_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "free_company" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="free_company_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Party</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="party_notifications" name="party_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "party" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="party_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>All Linkshells</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="all_linkshells_notifications" name="all_linkshells_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "all_linkshells" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="all_linkshells_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 1</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell1_notifications" name="linkshell1_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell1" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell1_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 2</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell2_notifications" name="linkshell2_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell2" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell2_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 3</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell3_notifications" name="linkshell3_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell3" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell3_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 4</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell4_notifications" name="linkshell4_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell4" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell4_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 5</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell5_notifications" name="linkshell5_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell5" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell5_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 6</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell6_notifications" name="linkshell6_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell6" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell6_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 7</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell7_notifications" name="linkshell7_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell7" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell7_notifications">&nbsp;</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkshell 8</td>
                            <td>
                                <input type="checkbox" class="filled-in" id="linkshell8_notifications" name="linkshell8_notifications"
                                    @foreach ($notificationSettings as $notification)
                                        @if ($notification['type'] == "linkshell8" && $notification['setting'] == "on")
                                            checked="checked"
                                        @endif
                                    @endforeach
                                />
                                <label for="linkshell8_notifications">&nbsp;</label>
                            </td>
                        </tr>
                    </table>

                    <div class="clearfix">&nbsp;</div>


                    {{ csrf_field() }}

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>
    </div>

    <div id="update-email" class="col s12 m6 l6 offset-m3 offset-l3">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Update Email</h5>
            </div>

            <div class="card-panel-content col s12">
                <p>When you change your email, you will be sent a verification email. You must verify your email on your next login.</p><br>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

                @if (Session::has('status'))
                    <p>{{ Session::get('status') }}</p>
                @endif

                {!! Form::model($user, ['route' => ['Settings-SaveEmail']]) !!}
                <label>Update your email:</label>
                {!! Form::text('email') !!}

                <label>Insert your current password:</label>
                {!! Form::password('password') !!}

                {!! Form::submit('Save Email', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>
    </div>

    <div id="update-password" class="col s12 m6 l6 offset-m3 offset-l3">
        <div class="card-panel">
            <div class="card-panel-title">
                <span class="right">
                    <a href="#!"></a>
                </span>

                <h5>Update Password</h5>
            </div>

            <div class="card-panel-content col s12">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

                @if (Session::has('status'))
                    <p>{{ Session::get('status') }}</p>
                @endif

                {!! Form::model(['route' => ['Settings-SavePassword']]) !!}
                <label>Insert your current password:</label>
                {!! Form::password('password_current') !!}

                <label>Insert new password:</label>
                {!! Form::password('password') !!}

                <label>Verify new password:</label>
                {!! Form::password('password_confirmation') !!}
                {!! Form::submit('Save Password', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>

            <div class="clearfix">&nbsp;</div>
        </div>
    </div>
</div>

@endsection