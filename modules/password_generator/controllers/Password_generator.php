<?php

final class Password_generator extends Trongate
{
    private bool $has_error;
    private array $error_message;


    private PasswordService $password_service;

    private $template_to_use = 'clean_narrow';


    function __construct($module_name = null)
    {
        parent::__construct($module_name);

        $this->has_error     = false;
        $this->error_message = [];

        require_once __DIR__.'/../services/PasswordService.php';
        $this->password_service = new PasswordService();

        $this->module('api_helper');
    }


    /** Password generator view */
    function index()
    {
        $data['view_file'] = 'index';
        $this->template($this->template_to_use, $data);
    }


    /**
     * Generate password api endpoint
     *
     * @return void
     * @throws \Exception
     */
    function generate()
    {
        api_auth();

        $this->module('api_helper');
        $params = $this->api_helper->_get_params_from_url(3);

        extract($params);
        settype($length, 'integer');

        // Validate
        if ($length > $this->password_service::PASSWORD_MAX_LENGTH) {
            $this->has_error              = true;
            $this->error_message['error'] = 'Password length exceeds the maximum allowed ('.$this->password_service::PASSWORD_MAX_LENGTH.')';

        } else {
            if ($length <= 0) {
                $this->has_error              = true;
                $this->error_message['error'] = 'Password length cannot be zero or negative.';
            }
        }

        // Error response
        if ($this->has_error === true) {
            echo $this->api_helper->_response($this->error_message, $this->password_service->_get_error_code());
            die;
        }


        $args = [
            'length'    => $length,
            'lowercase' => $lowercase == 'true', // boolean
            'uppercase' => $uppercase == 'true',
            'numbers'   => $numbers == 'true',
            'symbols'   => $symbols == 'true',
        ];


        $result = $this->password_service->_generate_safe_password($args);

        if (array_key_exists('error', $result)) {
            echo $this->api_helper->_response($result, $this->password_service->_get_error_code());
            die;
        }

        // success
        echo $this->api_helper->_response($result);
        die;
    }

}
