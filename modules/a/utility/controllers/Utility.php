<?php

class Utility extends Trongate
{

    /**
     * Create unix timestamp (elapsed seconds from 1970-01-01)
     *
     */
    public function create_timestamp(): int
    {
        // current datetime
        $date = new DateTime();
        // convert to seconds
        return $date->getTimestamp();
    }

    /**
     * Generate version 4 UUIDs
     * @see https://www.php.net/manual/en/function.com-create-guid
     */
    public function create_guid(): string
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
        // fallback
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', random_int(0, 65535), random_int(0, 65535),
            random_int(0, 65535), random_int(16384, 20479), random_int(32768, 49151), random_int(0, 65535),
            random_int(0, 65535), random_int(0, 65535));
    }

}
