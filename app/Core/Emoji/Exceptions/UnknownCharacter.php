<?php

namespace EQM\Core\Emoji\Exceptions;

use Exception;

class UnknownCharacter extends Exception
{
    /**
     * @param $character
     * @return static
     */
    public static function create($character)
    {
        return new static("Character `{$character}` does not exist");
    }
}
