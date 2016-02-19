<?php
namespace EQM\Http;

class ProtocolPrepender
{
    /**
     * @param string $url
     * @return string
     */
    public function prepend($url)
    {
        $url = strtolower($url);
        if (substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://') {
            return $url;
        }
        return 'http://' . $url;
    }
}
