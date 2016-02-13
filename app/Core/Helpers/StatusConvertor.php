<?php
namespace EQM\Core\Helpers;

class StatusConvertor
{
    /**
     * @param string $text
     * @return string
     */
    public function convert($text)
    {
        $text = $this->convertLinks($text);
        $text = $this->convertYoutube($text);

        return $text;
    }

    /**
     * @param string $text
     * @return string
     */
    private function convertLinks($text)
    {
        $regex = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';

        if (str_contains($text, 'http://')) {
            $text = str_replace('http://', '', $text);
        }

        if (str_contains($text, 'https://')) {
            $text = str_replace('https://', '', $text);
        }

        if (! str_contains($text, 'youtu') && ! (str_contains($text, 'watch?V'))) {
            $text = preg_replace($regex, '<a href="http://$0" target="_blank">$0</a>', $text);
        }

        return $text;
    }

    /**
     * @param string $text
     * @return string
     */
    private function convertYoutube($text) {
        return preg_replace(
            "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
            "<iframe src=\"//www.youtube.com/embed/$2\" width=\"420\" height=\"315\" allowfullscreen></iframe>",
            $text
        );
    }
}
