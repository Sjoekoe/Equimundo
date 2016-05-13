<?php
namespace spec\EQM\Core\Helpers;

use EQM\Core\Helpers\StatusConvertor;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class StatusConvertorSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StatusConvertor::class);
    }

    function it_leaves_a_normal_text_untouched()
    {
        $this->convert('This is a normal text with no special characters.')
            ->shouldReturn ('This is a normal text with no special characters.');
    }

    function it_returns_a_http_url_to_a_link()
    {
        $this->convert('This is a text with a link to http://www.google.be')
            ->shouldReturn('This is a text with a link to <a href="http://www.google.be" target="_blank">www.google.be</a>');
    }

    function it_returns_a_https_url_to_a_link()
    {
        $this->convert('This is a text with a link to https://www.google.be')
            ->shouldReturn('This is a text with a link to <a href="http://www.google.be" target="_blank">www.google.be</a>');
    }

    function it_returns_a_www_url_to_a_link()
    {
        $this->convert('This is a text with a link to www.google.be')
            ->shouldReturn('This is a text with a link to <a href="http://www.google.be" target="_blank">www.google.be</a>');
    }

    function it_converts_youtube_links_to_embedded_videos()
    {
        $this->convert('www.youtube.com/watch?v=2345')
            ->shouldReturn('<iframe src="//www.youtube.com/embed/2345" width="420" height="315" allowfullscreen> </iframe>');
    }
}
