/**
 *
 * Search the top 10 GitHub repositories by language
 *
 */
function baseStatsData() {

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

    const propertiesToRound = [ 'amean', 'stdev', 'variance'];


    return {

        // current day
        sampleData: [],
        baseStats: undefined,
        percentileStats: undefined,

        init() {

        },

        isDataReady() {
            return this.baseStats !== undefined
        },

        getObjectKeys(obj) {
            return Object.keys(obj)
        },

        convertOutliers() {
            let outliers = this.baseStats.outliers.value;
            outliers = outliers.toString().replaceAll(',', ', ');
            this.baseStats.outliers.value = outliers
        },

        roundValues() {
            for(let i = 0; i < propertiesToRound.length; i++) {
                if (propertiesToRound[i].name === 'outliers') {
                    continue;
                }
                this.baseStats[propertiesToRound[i]].value = Math.round(this.baseStats[propertiesToRound[i]].value);
            }
        },


        getDataFromCSV(apiPath) {

            // Send request to the api endpoint
            fetch(apiPath, config)
                .then((response) => response.json())
                .then((data) => {
                    if (!data) {
                        console.error('Error occured while connecting to the OpenWeather API');
                    } else {
                        this.sampleData = data.data;

                        // get percentile values from the array of numbers
                        this.percentileStats = window.basestats.getAllPercentiles(this.sampleData)

                        // get basic stats from the array of numbers, save it
                        this.baseStats = window.basestats.getStats(this.sampleData)

                        // post-processing steps
                        this.convertOutliers();
                        this.roundValues();

                    }
                });
        }

    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('baseStatsData', baseStatsData);
});
