<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="Publisher" href="https://plus.google.com/u/0/b/114324010963091567789/114324010963091567789">
    <meta name="description" content="The social network for horses. Create profiles, find relatives, keep track of the palmares and share their daily life">

    <title>Equimundo - The social network for horses</title>

    <link href="/css/app.css" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    @if (App::environment('production'))
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-65362816-1', 'auto');
            ga('send', 'pageview');
        </script>
    @endif
</head>
<body id="page-top" class="landing-page">
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="page-scroll" href="#page-top">Home</a></li>
                    <li><a class="page-scroll" href="#features">Features</a></li>
                    <li><a class="page-scroll" href="#testimonials">Testimonials</a></li>
                    <li><a class="page-scroll" href="#contact">Contact</a></li>
                    <li><a href="{{ route('register') }}">Sign Up</a></li>
                    <li><a href="{{ route('login') }}">Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        <li data-target="#inSlider" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h1>The social network for horses</h1>
                    <p>Create profiles, find relatives, keep track of the palmares<br/>
                        and share their daily life</p>
                    <p>
                        <a class="btn btn-lg btn-primary" href="{{ route('register') }}" role="button">Register now</a>
                    </p>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back one"></div>

        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption blank">
                    <h2>Find out more about <br/> the history of your horse.</h2>
                    <p>Our engine let's you find relatives from your horse you never knew about.</p>
                    <p><a class="btn btn-lg btn-primary" href="{{ route('register') }}" role="button">Register now</a></p>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>
    </div>
    <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<section id="features" class="container features">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h2>Give your horse a voice!<br/> <span class="navy"> Share their lives.</span> </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center wow fadeInLeft">
            <div>
                <i class="fa fa-user features-icon"></i>
                <h2>Create profiles</h2>
                <p>Create a unique profile for each horse you own, ride with or take care of.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-share-alt features-icon"></i>
                <h2>Find relatives</h2>
                <p>Fill in the pedigree like the in the passport. And the UELN will make sure you can connect to relatives of your horse.</p>
            </div>
        </div>
        <div class="col-md-6 text-center  wow zoomIn">
            <img src="{{ asset('images/profile.png') }}" alt="profile" class="img-responsive">
        </div>
        <div class="col-md-3 text-center wow fadeInRight">
            <div>
                <i class="fa fa-trophy features-icon"></i>
                <h2>Event history</h2>
                <p>Keep track of the career of the horse. Whether it is a CSI5* or a basic license test.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-users features-icon"></i>
                <h2>Create communities</h2>
                <p>Create a group for your company, sport team, or friends to have small communities and see what they did on other days.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h2>Discover how other horses do.</h2>
            <p>On your timeline you can find all updates in the blink of an eye. </p>
        </div>
    </div>
    <div class="row features-block">
        <div class="col-lg-6 features-text wow fadeInLeft">
            <small>Equimundo</small>
            <h2>The new timeline </h2>
            <p>Updates are made in the name of a horse or a company/group. All replies on the updates or made in your own name.</p>
        </div>
        <div class="col-lg-6 text-right wow fadeInRight">
            <img src="{{ asset('images/timeline.png') }}" alt="timeline" class="img-responsive pull-right">
        </div>
    </div>
</section>


<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h2>What makes us different than other social networks.</h2>
                <p>Even more great features. </p>
            </div>
        </div>
        <div class="row features-block">
            <div class="col-lg-3 features-text wow fadeInLeft">
                <small>PEDIGREE</small>
                <h2>Designed to connect. </h2>
                <p>Every horse has it's own unique life number. Whit this number, and the horses pedigree, we are able to connect you with all the family members of your horse. Once a family member registers, we will automatically inform you.</p>
            </div>
            <div class="col-lg-6 text-right m-t-n-lg wow zoomIn">
                <img src="{{ asset('images/pedigree.png') }}" class="img-responsive" alt="pedigree">
            </div>
            <div class="col-lg-3 features-text text-right wow fadeInRight">
                <small>PALMARES</small>
                <h2>Remember everything. </h2>
                <p>What is a better way to keep track of the athletic achievements with a visualisation? Create an instant update with some visualisation when you win the olympic gold, and remember it forever! (A small local competition is just as fine as well!)</p>
            </div>
        </div>
    </div>

</section>


<section id="testimonials" class="navy-section testimonials">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center wow zoomIn">
                <i class="fa fa-comment big-icon"></i>
                <h2>
                    What our users say.
                </h2>
                <div class="testimonials-text">
                    <i>"Equimundo has given me the opportunity to meet with a half-brother of my horse on the first day I registered. Also people on other social media are less complaining for posting less pictures of Corleana on there."</i>
                </div>
                <small>
                    <strong>Sofie Poot</strong> - Owner of <a href="{{ route('horses.show', 'corleana') }}" class="text-primary">Corleana</a>
                </small>
            </div>
        </div>
    </div>
</section>

@if (App::Environment('production'))
    <section class="comments gray-bg n-m-t">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h2>Some of our horses.</h2>
                </div>
            </div>
            <div class="row features-block">
                <div class="col-lg-4">
                    <?php $horse = \EQM\Models\Horses\EloquentHorse::where('slug', 'florina')->first(); ?>
                    <div class="comments-avatar">
                        <a href="" class="pull-left">
                            <img alt="image" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
                        </a>
                        <div class="media-body">
                            <div class="commens-name">
                                <a href="{{ route('horses.show', $horse->slug()) }}">
                                    {{ $horse->name() }}
                                </a>
                            </div>
                            <small class="text-muted">{{ $horse->father()->name() }} X {{ $horse->mothersFather()->name() }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <?php $horse = \EQM\Models\Horses\EloquentHorse::where('slug', 'corleana')->first(); ?>
                    <div class="comments-avatar">
                        <a href="" class="pull-left">
                            <img alt="image" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
                        </a>
                        <div class="media-body">
                            <div class="commens-name">
                                <a href="{{ route('horses.show', $horse->slug()) }}">
                                    {{ $horse->name() }}
                                </a>
                            </div>
                            <small class="text-muted">{{ $horse->father()->name() }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <?php $horse = \EQM\Models\Horses\EloquentHorse::where('slug', 'jufried-mw')->first(); ?>
                    <div class="comments-avatar">
                        <a href="" class="pull-left">
                            <img alt="image" src="{{ route('file.picture', $horse->getProfilePicture()->id()) }}">
                        </a>
                        <div class="media-body">
                            <div class="commens-name">
                                <a href="{{ route('horses.show', $horse->slug()) }}">
                                    {{ $horse->name() }}
                                </a>
                            </div>
                            <small class="text-muted">{{ $horse->father()->name() }} X {{ $horse->mothersFather()->name() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h2>More and more extra great features</h2>
                <p>Not only for horses. </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1 features-text">
                <small>ADVERTISERS</small>
                <h2>More ROI </h2>
                <i class="fa fa-bar-chart big-icon pull-right"></i>
                <p>Ever wondered how much of your advertising money goes down the drain because of views of people who aren't interested. At Equimundo you have a 100% interested target area of potential customers.</p>
                <p><a href="mailto:info@equimundo.com">Ask more information here.</a></p>
            </div>
            <div class="col-lg-5 features-text">
                <small>BUSINESSES</small>
                <h2>Follow your clients</h2>
                <i class="fa fa-users big-icon pull-right"></i>
                <p>Whether you are a farrier, a vet, own a stable, or even make embroyments on horse tacks. You can create a page for your business, so people and horses can join your page. This allows you to keep a closer contact with human and animal.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1 features-text">
                <small>BREEDERS</small>
                <h2>Follow-up forever </h2>
                <i class="fa fa-clock-o big-icon pull-right"></i>
                <p>Ever wondered what happened with that foal you sold 6 months ago? Why don't yu start a profile from the first day when it is born. A horse profile is transferable to the ne owners, so you can follow it even it has traveled to the other side of the world.</p>
            </div>
            <div class="col-lg-5 features-text">
                <small>STUDBOOKS</small>
                <h2>Keeping a clear view </h2>
                <i class="fa fa-eye big-icon pull-right"></i>
                <p>Looking for that new approved stallion to improve your studbook? At Equimundo you can find horses that never went to an examination, but still are interesting breeding material.</p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="gray-section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h2>Contact Us</h2>
                <p>If you want more information, or just want to drop us a line.</p>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-3 col-lg-offset-3">
                <address>
                    <strong><span class="navy">Equimundo</span></strong><br/>
                    Schoenmarkt 35<br/>
                    2000 Antwerp, Belgium<br/>
                </address>
            </div>
            <div class="col-lg-4">
                <p class="text-color">
                    Equimundo. The first social network in the world for horses. Share their daily life, follow other horses, show their palmares and find relatives.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:info@equimundo.com" class="btn btn-primary">Send us an e-mail</a>
                <p class="m-t-sm">
                    Or follow us on other social platforms
                </p>
                <ul class="list-inline social-icon">
                    <li><a href="https://twitter.com/Equimundo" target="_blank"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li><a href="https://www.facebook.com/equimundoOfficial/" target="_blank"><i class="fa fa-facebook"></i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p><strong>&copy; {{ Carbon\Carbon::now()->format('Y') }} Equimundo</strong></p>
                <a href="{{ route('terms_of_service') }}">Terms</a> -
                <a href="{{ route('privacy') }}">Privacy</a> -
                <a href="{{ route('sitemap') }}">Sitemap</a>
            </div>
        </div>
    </div>
</section>

<!-- Mainly scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
<script src="/js/all.js"></script>

<script>

    $(document).ready(function () {

        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
            $("#navbar").collapse('hide');
        });
    });

    var cbpAnimatedHeader = (function() {
        var docElem = document.documentElement,
                header = document.querySelector( '.navbar-default' ),
                didScroll = false,
                changeHeaderOn = 200;
        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 250 );
                }
            }, false );
        }
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= changeHeaderOn ) {
                $(header).addClass('navbar-scroll')
            }
            else {
                $(header).removeClass('navbar-scroll')
            }
            didScroll = false;
        }
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();

    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();

</script>

</body>
</html>
