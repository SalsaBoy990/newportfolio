<?php

class FrontService extends Model {

    /**
     * My phone number
     *
     * @var string
     */
    private string $phoneNumber = '+36204427225';


    /**
     * My email address
     *
     * @var string
     */
    private string $emailAddress = 'gandras@passmail.net';


    /**
     * My GitHub profile
     *
     * @var string
     */
    private string $githubLink = 'https://github.com/Salsaboy990';


    /**
     * @return string
     */
    public function get_phone_number(): string
    {
        return $this->phoneNumber;
    }


    /**
     * @return string
     */
    public function get_email_address(): string
    {
        return $this->emailAddress;
    }

    /**
     * @return string
     */
    public function get_github_link(): string
    {
        return $this->githubLink;
    }




}
