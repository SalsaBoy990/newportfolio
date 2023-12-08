<?php

class PasswordService
{
    public const PASSWORD_MAX_LENGTH = 50;


    private const LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';


    private const UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';


    private const NUMBERS = '1234567890';


    private const SYMBOLS = '`~!@#$%^&*()-_=+]}[{;:,<.>/?\'"\|';


    /**
     * To store password
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $charset;


    /**
     * @var Api_helper
     */
    private Api_helper $api_helper;


    /**
     *
     */
    function __construct()
    {
        require_once dirname(__DIR__, 2).'/a/api_helper/controllers/Api_helper.php';
        $this->api_helper = new Api_helper();

        $this->password = '';
        $this->charset  = '';

    }


    /**
     * Generate safe password
     *
     * @param  array  $args
     *
     * @return string[]
     * @throws \Exception
     */
    public function _generate_safe_password(array $args): array
    {
        extract($args);

        // Contains specific character groups
        if ($lowercase === true) {
            $this->charset .= self::LOWERCASE;
        }
        if ($uppercase === true) {
            $this->charset .= self::UPPERCASE;
        }
        if ($numbers === true) {
            $this->charset .= self::NUMBERS;
        }
        if ($symbols === true) {
            $this->charset .= self::SYMBOLS;
        }


        if ($this->charset === '') {
            return ['error' => 'At least check one of the checkboxes!'];
        }


        try {
            // Loop until the preferred length reached
            for ($i = 0; $i < $length; $i++) {
                // get randomized length
                $_rand = random_int(0, strlen($this->charset) - 1);
                // add one random character from the string
                $this->password .= substr($this->charset, $_rand, 1);
            }
        } catch (Exception $ex) {
            if (ENV === 'dev') {
                json($ex);
            }

            return ['error' => 'Appropriate source of randomness not achieved. Please try it again.'];
        }


        return ['password' => $this->password];
    }


    /**
     * Handle response
     *
     * @param  array  $response
     * @param  int  $response_code
     *
     * @return string
     */
    private function _response(array $response, int $response_code = 200): string
    {
        $output['body'] = json_encode($response);
        $output['code'] = $response_code;

        $code = $output['code'];
        http_response_code($code);

        return $output['body'];
    }


    /**
     * Gets the error codes (400 or 500)
     *
     * @return int
     */
    public function _get_error_code(): int
    {
        return $this->charset === '' ? 400 : 500;
    }

}
