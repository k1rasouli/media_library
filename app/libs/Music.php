<?php

namespace App\libs;

use App\Models\Media;

class Music extends Media
{
    /**
     * @var array|string[]
     *
     * Allowed Music class extension.
     * Adding values to this array has no effect on application implemented logic (abstraction).
     * This property is set to private(Encapsulation)
     */
    private array $allowed_extensions = ['mp3'];

    /**
     * @param string $extension
     * @return bool
     *
     * This method is inherited form Media Model/Class
     */
    public function check_extension(string $extension): bool
    {
        return in_array($extension, $this->allowed_extensions);
    }

    /**
     * @param string $address
     * @return string
     *
     * This method is inherited form Media Model/Class
     */
    public function getLink(string $address) : string
    {
        return "AUDIO TAG: " . $address;
    }
}
