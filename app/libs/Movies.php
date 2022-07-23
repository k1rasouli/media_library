<?php

namespace App\libs;

use App\Models\Media;

class Movies extends Media
{
    /**
     * @var array|string[]
     *
     * Allowed Movies class extension.
     * Adding values to this array has no effect on application implemented logic (abstraction).
     * This property is set to private(Encapsulation)
     */
    private array $allowed_extensions = ['mp4', 'm4v'];

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
        return "VIDEO TAG: " . $address;
    }
}
