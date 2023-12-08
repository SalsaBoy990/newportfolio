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


function set_value_or_default($var, $default_value)
{
    return empty($var) ? $default_value : $var;
}


/**
 * Gets the current page url
 * @return string
 */
function get_current_url(): string {
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    return trim( htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' ) );
}

/**
 * Check if the link is active
 *
 * @param  string  $link
 *
 * @return bool
 */
function is_active_link(string $link): bool {
    return get_current_url() === $link;
}
