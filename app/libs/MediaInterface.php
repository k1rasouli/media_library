<?php

namespace App\libs;

interface MediaInterface
{
    /**
     * @param string $extension
     * @return bool
     *
     * This method required so media type and file extensions gets checked
     */
    public function check_extension(string $extension) : bool;

    /**
     * @param string $address
     * @return string
     *
     * This method is to retrieve proper html tag and link based on media type
     */
    public function getLink(string $address) : string;
}
