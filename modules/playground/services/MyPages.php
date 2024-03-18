<?php

namespace services;

class MyPages
{

    /**
     * @return string[]
     */
    public function get_my_pages(): array
    {
        return [
            'Clean UI Module'                       => 'ui-clean',
            'Current Weather Module'                => 'weather/city',
            'Safe Password Generator Module'        => 'password_generator',
            'Poll Module'                           => 'poll',
            'Gallery Module'                        => 'gallery',
            'Basic Statistics Module'               => 'basestats',
            'GitHub Repo Search by Language Module' => 'github_repositories',
            'Simple Mail Send'                      => 'mailer/contact',
            'Fake Payment Module'                   => 'payment/form',
            'Guitar Module'                         => 'guitar/information',
            'Blogpost entries Module'               => 'entries',
        ];
    }

}
