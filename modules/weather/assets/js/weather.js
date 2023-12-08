/**
 *
 * Search the top 10 GitHub repositories by language
 *
 */
function openWeatherData() {

    const config = {
        method: 'GET',
        mode: 'same-origin',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
    };

    // visualize weather
    const icon_mapping = {
        '01d': 'wi-day-sunny',
        '01n': 'wi-night-clear',
        '02d': 'wi-day-cloudy',
        '02n': 'wi-night-alt-cloudy',
        '03d': 'wi-cloud',
        '03n': 'wi-night-alt-cloudy',
        '04d': 'wi-cloudy',
        '04n': 'wi-night-alt-cloudy',
        '09d': 'wi-rain',
        '09n': 'wi-night-alt-rain',
        '10d': 'wi-day-rain',
        '10n': 'wi-night-alt-rain',
        '11d': 'wi-thunderstorm',
        '11n': 'wi-night-alt-thunderstorm',
        '13d': 'wi-snow',
        '13n': 'wi-night-alt-snow',
        '50d': 'wi-fog',
        '50n': 'wi-night-alt-fog'
    };

    const maxForecastDays = 4;

    return {
        // user input
        cityName: '',

        // days of the week
        forecastDays: [],
        weekdayNames: [],

        // the queried data
        weather: undefined,
        forecasts: undefined,

        // current day
        currentDay: undefined,

        init() {
            this.cityName = 'Szeged';
            this.weekdayNames = ['Vas', 'Hé', 'Ke', 'Sze', 'Cs', 'P', 'Szo'];

            // get the next X days for the forecasts
            this.currentDay = new Date().getDay();

            for (let i = 1; i <= maxForecastDays; i++) {
                let now = new Date();
                now = now.setDate(now.getDate() + i);
                let dayNumber = new Date(now).getDay();
                this.forecastDays.push(this.weekdayNames[dayNumber]);
            }

        },

        isPropertySet($prop, data = null) {
            if (!data) {
                return this.weather !== undefined && this.weather.hasOwnProperty($prop);
            } else {
                return data.hasOwnProperty($prop);
            }
        },

        hasError() {
            return this.isPropertySet('cod') && this.weather.cod !== 200;
        },

        getIcon(iconName) {
            return icon_mapping[iconName] || '';
        },


        getCurrentWeather(apiPath) {
            let args = {};
            args['city_name'] = this.cityName;
            const queryParams = new URLSearchParams(args);

            // Send request to the api endpoint
            fetch(apiPath + '?' + queryParams.toString(), config)
                .then((response) => response.json())
                .then((data) => {
                    if (!data) {
                        console.log('Error occured while connecting to the OpenWeather API');
                    } else {
                        this.weather = data.current;
                        this.forecasts = data.forecast.list;
                        this.forecasts.length = maxForecastDays;
                    }
                });
        }

    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('openWeatherData', openWeatherData);
});

