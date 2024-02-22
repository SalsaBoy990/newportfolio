<?php

final class Weather extends Trongate
{
    /**
     * @var WeatherService
     */
    private WeatherService $weather_service;


    /**
     * @var string
     */
    private string $template_to_use = 'clean_narrow';


    /**
     * @param $module_name
     *
     * @throws ReflectionException
     */
    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        require_once __DIR__.'/../services/WeatherService.php';
        $this->weather_service = new WeatherService();

        $this->module('api_helper');
    }


    /**
     * Weather by city name page
     * @return void
     * @throws Exception
     */
    public function city(): void
    {
        $data['view_file'] = 'index';
        $this->template($this->template_to_use, $data);
    }


    /**
     * Public endpoint - current weather
     * @return void
     */
    function current()
    {
        api_auth();

        // get input value; sanitize, and process it
        $this->weather_service->_input();

        $current_weather = $this->weather_service->_get_current_weather();
        $forecast        = $this->weather_service->_forecast();

        $results = [
            'current'  => json_decode($current_weather),
            'forecast' => json_decode($forecast),
        ];

        echo json_encode($results);
        die;
    }
}
