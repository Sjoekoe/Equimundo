<?php
namespace spec\EQM\Http;

use EQM\Http\ProtocolPrepender;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProtocolPrependerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProtocolPrepender::class);
    }
    function it_should_convert_a_string_to_lowercase()
    {
        $this->prepend('hTTP://wWw.EXAMPLE.com')->shouldReturn('http://www.example.com');
    }
    function it_should_prepend_a_valid_url_to_a_string()
    {
        $this->prepend('www.example.com')->shouldReturn('http://www.example.com');
    }
    function it_lets_a_url_be_the_same_with_the_correct_protocol()
    {
        $this->prepend('http://www.example.com')->shouldReturn('http://www.example.com');
    }
    function it_lets_a_secure_url_be_the_same()
    {
        $this->prepend('https://www.example.com')->shouldReturn('https://www.example.com');
    }
}
