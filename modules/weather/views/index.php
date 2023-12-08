<!-- Inspired by https://codepen.io/adam-gora/pen/YZmPEB -->
<section x-data="openWeatherData" class="content-600">

    <input type="text" x-model="cityName" value="">

    <div x-show="hasError()" x-text="isPropertySet('cod') && weather.cod + ' - ' + weather.message" class="panel danger">
    </div>

    <button @click="getCurrentWeather('<?= BASE_URL ?>' + 'weather/current/')">Get current weather</button>


    <div class="ow-widget box round margin-top-1-5" x-show="isPropertySet('name')" x-cloak>
        <div class="ow-row">
            <span class="ow-city-name" x-text="isPropertySet('name') && weather.name"></span>
        </div>
        <div class="ow-row">
            <div class="wi ow-ico ow-ico-current pull-left" :class="isPropertySet('weather') && getIcon(weather.weather[0].icon)"></div>
            <div class="ow-temp-current pull-left" x-text="isPropertySet('main') && Math.round(weather.main.temp) + ' C&deg'"></div>
            <div class="ow-current-desc pull-left">
                <div x-text="isPropertySet('weather') && weather.weather[0].description"></div>
                <div>Pressure: <span class="ow-pressure" x-text="isPropertySet('main') && weather.main.pressure + ' hPa'"></span></div>
                <div>Humidity: <span class="ow-humidity" x-text="isPropertySet('main') && weather.main.humidity + ' %'"></span></div>
                <div>Wind: <span class="ow-wind" x-text="isPropertySet('wind') && weather.wind.speed + ' km/h'"></span></div>
            </div>
        </div>
        <div class="ow-row ow-forecast">

            <template x-for="(forecast, index) in forecasts" :key="index">
                <div class="ow-forecast-item">
                    <div class="ow-day"><strong x-text="forecastDays[index]"></strong></div>
                    <div class="ow-day" x-text="isPropertySet('weather', forecast) && forecast.weather[0].description"></div>
                    <div class="wi ow-ico ow-ico-forecast" :class="isPropertySet('weather', forecast) && getIcon(forecast.weather[0].icon)"></div>
                    <div class="ow-forecast-temp">
                        <span x-text="isPropertySet('temp', forecast) && Math.round(forecast.temp.min)  + ' C&deg'"></span>
                        -
                        <span x-text="isPropertySet('temp', forecast) && Math.round(forecast.temp.max)  + ' C&deg'"></span>
                    </div>
                </div>
            </template>

        </div>
    </div>
</section>

<link rel="stylesheet" type="text/css" href="weather_module/css/weather-icons.css">
<link rel="stylesheet" type="text/css" href="weather_module/css/weather.css">
<script src="weather_module/js/weather.js"></script>
