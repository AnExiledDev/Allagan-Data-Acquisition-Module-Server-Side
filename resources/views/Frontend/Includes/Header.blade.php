<!DOCTYPE html>
<html>
<head>
    <title>Allagan Data Acquisition Module</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css" media="screen,projection" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tabby/11.0.2/css/tabby.min.css" rel="stylesheet">
    <link href="/css/Basic.css" rel="stylesheet">
    <link href="/css/Core.css" rel="stylesheet">

    <!-- Javascript -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabby/11.0.2/js/tabby.min.js"></script>
    <!--<script type="text/javascript" src="/Javascript/Complete.min.js"></script>-->
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
        <div class="navbar-fixed fixed">
            <nav>
                <div class="nav-wrapper ">
                    <a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons">menu</i></a>

                    <ul class="side-nav fixed z-depth-3" id="mobile-nav">
                        <li><img src="/Images/ADAM.png" width="300px" /></li>

                        <li class="divider"></li>

                        <li><a href="/" class="clearfix"><i class="material-icons left">dashboard</i> Home</a></li>
                        <li><a href="{{ route('Login') }}" class="clearfix"><i class="material-icons left">assignment</i> Login</a></li>
                        <li><a href="{{ route('Register') }}" class="clearfix"><i class="material-icons left">assignment_ind</i> Register</a></li>
                        <li><a href="/Documentation/FrequentlyAskedQuestions/" class="clearfix" target="_blank"><i class="material-icons left">question_answer</i> FAQ</a></li>
                        <li><a href="/Documentation" class="clearfix" target="_blank"><i class="material-icons left">info_outline</i> Documentation</a></li>
                        <li><a href="/TermsOfService" class="clearfix"><i class="material-icons left">assignment</i> Terms of Service</a></li>
                        <li><a href="/PrivacyPolicy" class="clearfix"><i class="material-icons left">assignment_ind</i> Privacy Policy</a></li>
                        <!--<li><a href="/RefundPolicy" class="clearfix"><i class="material-icons left">assignment</i> Refund Policy</a></li>-->
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>