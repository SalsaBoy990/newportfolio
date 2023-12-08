<?php

/**
 * Language Switcher
 */
class Localization extends Trongate
{
    /**
     * Change website language
     * stores its value in a cookie
     *
     * @param  string  $lang
     *
     * @return void
     */
    public function language(string $lang): void
    {
        settype($lang, 'string');
        setcookie('language', htmlspecialchars($lang), time() + (86400 * 30), "/");
        redirect('');
    }


    public function test(): void
    {
        $params      = file_get_contents('php://input');
        $posted_data = (object) json_decode($params);

        var_dump($posted_data);
    }
}
