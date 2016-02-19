<?php
namespace spec\EQM\Http\Validators;

use EQM\Http\ProtocolPrepender;
use EQM\Http\Validators\UrlHostValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UrlHostValidatorSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(new ProtocolPrepender());
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(UrlHostValidator::class);
    }
    function it_returns_true_with_an_http_prepended_url()
    {
        $this->validate('', 'http://www.test.com')->shouldReturn(true);
    }
    function it_returns_true_with_no_http_prepended()
    {
        $this->validate('',  'www.test.com')->shouldReturn(true);
    }
    function it_even_returns_true_without_www_prepended()
    {
        $this->validate('', 'test.com')->shouldReturn(true);
    }
    function it_returns_false_when_a_space_is_in_the_string()
    {
        $this->validate('', 'www.test com')->shouldReturn(false);
    }
    function it_returns_false_when_special_characters_are_used()
    {
        $this->validate('', 'www.test°$*.com')->shouldReturn(false);
    }
    function it_returns_false_for_a_simple_string()
    {
        $this->validate('', 'test')->shouldReturn(false);
    }
    function it_returns_false_when_only_a_dot_is_entered()
    {
        $this->validate('', '.')->shouldReturn(false);
    }
}
