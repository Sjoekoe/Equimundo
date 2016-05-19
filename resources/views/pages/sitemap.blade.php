{{'<?xml version="1.0" encoding="UTF-8"?>'}}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('marketing') }}</loc>
    </url>
    <url>
        <loc>{{ route('privacy') }}</loc>
    </url>
    <url>
        <loc>{{ route('terms_of_service') }}</loc>
    </url>
</urlset>

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
