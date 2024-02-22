<?php

class WeatherService
{
    /**
     * @var string[]
     */
    private array $settings;


    /**
     * @var array
     */
    private array $params;


    /**
     * Open Weather API key
     */
    private const API_KEY = '6bd5b850178e2134497c4b965fbaf54e'; // this is not my api key


    /**
     * Current weather url
     */
    private const CURRENT_URL = 'https://api.openweathermap.org/data/2.5/weather';


    /**
     * Daily weather forecast
     */
    private const FORECAST_URL = 'https://api.openweathermap.org/data/2.5/forecast/daily';


    /**
     * Language
     */
    private const LANG = 'hu';


    /**
     * Units
     */
    private const UNITS = 'metric';


    private Api_helper $api_helper;

    /**
     *
     */
    public function __construct()
    {
        require_once dirname(__DIR__, 2).'/api_helper/controllers/Api_helper.php';
        $this->api_helper = new Api_helper();


        // Weather widget settings
        $this->settings = [
            'weather_url'  => self::CURRENT_URL,
            'forecast_url' => self::FORECAST_URL,
            'search_type'  => 'city_name',
            'city_name'    => 'Szeged',
        ];

        // Query parameters
        $this->params = [
            'q'     => $this->settings['city_name'],
            'appid' => self::API_KEY,
            'units' => self::UNITS,
            'lang'  => self::LANG,
        ];
    }


    /**
     * Custom weather forecast endpoint
     *
     * @return string
     */
    public function _forecast(): string
    {
        api_auth();

        // get input value; sanitize, and process it
        $this->_input();

        return $this->_get_weather_forecast();
    }


    /**
     * Get the current weather
     * @return string
     */
    public function _get_current_weather(): string
    {
        // generate api query with query strings
        $query = $this->_construct_query(self::CURRENT_URL);

        // make get call to the endpoint
        return $this->api_helper->_curl_call($query);
    }


    /**
     * Get weather forecast for 1-16 days ahead
     * @return string
     */
    public function _get_weather_forecast(): string
    {
        $params = array_merge($this->params, ['cnt' => 7]);

        // generate api query with query strings
        $query = $this->_construct_query(self::FORECAST_URL, $params);

        // make get call to the endpoint
        return $this->api_helper->_curl_call($query);

    }


    /**
     * Get user input, sanitize and process it
     * @return void
     */
    public function _input(): void
    {
        $params = $this->api_helper->_get_params_from_url(3);
        extract($params);

        // Sanitize
        settype($city_name, 'string');
        $city_name = ucfirst(strtolower($city_name));

        $this->settings['city_name'] = $city_name;
        $this->params['q']           = $city_name;
    }


    /**
     * Construct the query url
     *
     * @param  string  $url
     * @param  array|null  $params
     *
     * @return string
     */
    public function _construct_query(string $url, array|null $params = null): string
    {
        $query  = $url.'?';
        $values = array_values($params ?? $this->params);
        $keys   = array_keys($params ?? $this->params);
        $max    = sizeof($params ?? $this->params);

        for ($i = 0; $i < $max; $i++) {
            $param = $keys[$i].'='.$values[$i];
            $query .= ($i < $max - 1) ? $param.'&' : $param;
        }

        return $query;
    }
}
