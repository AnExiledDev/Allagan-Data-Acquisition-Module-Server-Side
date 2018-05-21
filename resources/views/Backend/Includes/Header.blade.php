<!DOCTYPE html>
<html>
<head>
    <title>Allagan Data Acquisition Module</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stylesheets -->
        <!-- MaterializeCSS -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css" media="screen,projection" rel="stylesheet">

        <!-- Tabby -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tabby/11.0.2/css/tabby.min.css" rel="stylesheet">

        <!-- jQuery -->
        <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <!-- Gridstack -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.2.6/gridstack.min.css" />

        <!-- Custom -->
        <link href="/css/Core.css" rel="stylesheet">

    <!-- Javascript -->
        <!-- jQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <!-- MaterializeCSS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>

        <!-- FontAwesome -->
        <script type="text/javascript" src="https://use.fontawesome.com/6e1589c539.js"></script>

        <!-- Tabby -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabby/11.0.2/js/tabby.min.js"></script>

        <!-- OneSignal -->
        <script type="text/javascript" src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>

        <!-- XIVDB -->
        <script type="text/javascript" src="https://secure.xivdb.com/tooltips.js"></script>

        <!-- Gridstack -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/lodash/4.17.4/lodash.min.js"></script>
        <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/gridstack.js/0.3.0/gridstack.min.js'></script>
        <script type="text/javascript" src="/js/gridstack.jQueryUI.min.js"></script>

        <!-- JinPlace -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jinplace/1.2.1/jinplace.min.js"></script>

        <!-- Custom -->
        <script type="text/javascript" src="/js/Complete.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <link rel="manifest" href="/manifest.json">
    <script>
        var OneSignal = window.OneSignal || [];

        OneSignal.push(["init", {
            appId: "35046846-6e3a-4914-84bb-2f5e99274159",
            autoRegister: true,
            notifyButton: {
                enable: true
            },
            welcomeNotification: {
                disable: true
            },
            persistNotification: false
        }]);
    </script>

    <script type="text/javascript">
        var xivdb_tooltips =
        {
            source: 'https://secure.xivdb.com',
            language: 'en'
        }
    </script>
</head>

<body>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-54424338-5', 'auto');
        ga('send', 'pageview');
    </script>
    <script type="text/javascript">
        var sc_project=11169994;
        var sc_invisible=1;
        var sc_security="12d66119";
        var scJsHost = (("https:" == document.location.protocol) ?
        "https://secure." : "http://www.");
        document.write("<sc"+"ript type='text/javascript' src='" +
        scJsHost+
        "statcounter.com/counter/counter.js'></"+"script>");
    </script>
    <noscript><div class="statcounter"><a title="shopify traffic
    stats" href="http://statcounter.com/shopify/"
    target="_blank"><img class="statcounter"
    src="//c.statcounter.com/11169994/0/12d66119/1/"
    alt="shopify traffic stats"></a></div></noscript>

    <header>
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper">
                    <a href="#" data-activates="mobile-nav" class="button-collapse show-on-large"><i class="material-icons">menu</i></a>
                    <a href="#" data-activates="burger-bar" class="burger-bar" style="display: none;"><i class="material-icons">menu</i></a>

                    <ul class="right">
                        <li class="hide-on-small-only">
                            <a href="{{ route('Download') }}">
                                <i class="fa fa-download material-icons right"></i> Download
                            </a>
                        </li>
                        <li>
                            <a href="#!" onclick="$('#Character-Select-modal').modal('open');">
                                <i class="material-icons right">view_module</i> {{ $character['player_name'] or 'Select Character' }}
                            </a>
                        </li>
                    </ul>

                    <ul class="side-nav z-depth-3" id="mobile-nav">
                        <li><img src="/Images/ADAM.png" width="300px" /></li>

                        <li class="divider"></li>

                        <li><a href="{{ route('Dashboard') }}" class="clearfix"><i class="material-icons left">dashboard</i> Dashboard</a></li>

                        @foreach ($UserPages as $UserPage)
                            <li>
                                <a href="{{ route('Page', ['Page' => $UserPage['id']]) }}" class="clearfix">
                                    <i class="fa fa-{{ $UserPage['page_icon'] or 'columns' }} material-icons left"></i> {{ $UserPage['page_name'] }}
                                </a>
                            </li>
                        @endforeach

                        <!--<li><a href="{{ route('BotInfo') }}" class="clearfix"><i class="material-icons left">android</i> Bot Information</a></li>
                        <li><a href="{{ route('Chat') }}" class="clearfix"><i class="material-icons left">chat_bubble_outline</i> Chat</a></li>
                        <li><a href="{{ route('Character') }}" class="clearfix"><i class="material-icons left">perm_identity</i> Character</a></li>
                        <li><a href="{{ route('Inventory') }}" class="clearfix"><i class="material-icons left">work</i> Inventory</a></li>
                        <li><a href="{{ route('Statistics') }}" class="clearfix"><i class="material-icons">trending_up</i> Statistics</a></li>-->
                        <li><a href="/Documentation" class="clearfix" target="_blank"><i class="material-icons">info_outline</i> Documentation</a></li>
                        <li><a href="{{ route('Settings') }}" class="clearfix"><i class="material-icons">settings</i> Settings</a></li>
                        <li><a href="{{ route('Download') }}" class="clearfix"><i class="fa fa-download material-icons"></i> Download</a></li>
                        <!--<li><a href="" class="clearfix"><i class="material-icons">receipt</i> Billing</a></li>-->
                        <li><a href="{{ route('Support') }}" class="clearfix"><i class="material-icons">live_help</i> Support</a></li>
                        <li><a href="{{ route('Logout') }}" class="clearfix"><i class="material-icons">power_settings_new</i> Logout</a></li>
                    </ul>

                    <ul class="side-nav fixed z-depth-3" id="burger-bar">
                        <li><a href="{{ route('Dashboard') }}" class="clearfix"><i class="material-icons left">dashboard</i></a></li>

                        @foreach ($UserPages as $UserPage)
                            <li>
                                <a href="{{ route('Page', ['Page' => $UserPage['id']]) }}" class="clearfix">
                                    <i class="fa fa-{{ $UserPage['page_icon'] or 'columns' }} material-icons left"></i>
                                </a>
                            </li>
                        @endforeach

                        <!--<li><a href="{{ route('BotInfo') }}" class="clearfix"><i class="material-icons left">android</i></a></li>
                        <li><a href="{{ route('Chat') }}" class="clearfix"><i class="material-icons left">chat_bubble_outline</i></a></li>
                        <li><a href="{{ route('Character') }}" class="clearfix"><i class="material-icons left">perm_identity</i></a></li>
                        <li><a href="{{ route('Inventory') }}" class="clearfix"><i class="material-icons left">work</i></a></li>
                        <li><a href="{{ route('Statistics') }}" class="clearfix"><i class="material-icons">trending_up</i></a></li>-->
                        <li><a href="/Documentation" class="clearfix" target="_blank"><i class="material-icons">info_outline</i></a></li>
                        <li><a href="{{ route('Settings') }}" class="clearfix"><i class="material-icons">settings</i></a></li>
                        <li><a href="{{ route('Download') }}" class="clearfix"><i class="fa fa-download material-icons"></i></a></li>
                        <!--<li><a href="" class="clearfix"><i class="material-icons">receipt</i> Billing</a></li>-->
                        <li><a href="{{ route('Support') }}" class="clearfix"><i class="material-icons">live_help</i></a></li>
                        <li><a href="{{ route('Logout') }}" class="clearfix"><i class="material-icons">power_settings_new</i></a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="clearfix">&nbsp;</div>

        @if (!isset($currentCharacter->id))
        <div class="row">
            <div id="accountSettings" class="col s12 m6 l4 offset-m3 offset-l4">
                <div class="card-panel">
                    @if(!isset($currentCharacter->id))
                        <p>You haven't selected a character, so data won't display below. To select a character click "Select Character" at the top right and choose a character. If a character is not listed there then either you haven't sent data to our server by connecting the plugin to our servers with a valid Auth Key, or there is something wrong. If you're connected but no characters are showing after a refresh, contact us on our Discord!</p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </header>

    <main>
        <div class="row">
            <div class="right" style="margin-right: 40px;">
                <a class="waves-effect waves-light btn" onclick="$('#Pages-settings-modal').modal('open');">Pages</a>
                <a class="waves-effect waves-light btn" onclick="$('#Widgets-settings-modal').modal('open');">Widgets</a>
            </div>
        </div>
        <br>