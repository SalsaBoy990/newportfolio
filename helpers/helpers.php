<?php

// TODO: Move them to the 'engine/tg_helpers' folder


/**
 * Get language from the cookie, or return the default language
 *
 * @return string
 */
function get_language(): string
{
    return isset($_COOKIE['language']) ? htmlentities($_COOKIE['language']) : DEFAULT_LANGUAGE;
}


/**
 * Returns all available languages (use it for example for the language switcher component)
 *
 * @return string[]
 */
function get_language_list(): array
{
    return LANGUAGES;
}
