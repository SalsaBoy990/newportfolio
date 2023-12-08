import base from "./modules/base";
import pc from "./modules/percentile";
import {statistics, statisticsNames} from "./modules/props";
import utils from "./utils/utils";


const main = {
    // Array of statistical properties that you can currently calculate
    statistics: statistics,

    statisticsNames: statisticsNames,


    // Calculate basic statistical properties
    // Args:
    // stats: array containing the stats to calculate see the 'vars' property above
    // data: array containing the data to calculate stats from
    // error handling needs enhancements...
    getStats: function (data) {

        if (arguments.length < 1) {
            throw new Error('You did not supply all the arguments.')
        }
        if (!utils.isArray(this.statistics) || !utils.isArray(data)) {
            throw new Error('Arguments of array type needed.')
        }

        // To store the result object.
        let result = {}
        let str
        for (let i = 0; i < this.statistics.length; i++) {
            switch (str = this.statistics[i]) {
                case 'sum':
                    result[str] = {name: this.statisticsNames[i], value: data.reduce(base.sum, 0)}
                    break

                case 'min':
                    result[str] = {name: this.statisticsNames[i], value: data.reduce(base.min)}
                    break

                case 'max':
                    result[str] = {name: this.statisticsNames[i], value: data.reduce(base.max)}
                    break

                case 'amean':
                    result[str] = {name: this.statisticsNames[i], value: base.amean(data)}
                    break

                case 'variance':
                    result[str] = {name: this.statisticsNames[i], value: base.variance(data)}
                    break

                case 'stdev':
                    result[str] = {name: this.statisticsNames[i], value: base.stdev(data)}
                    break

                case 'median':
                    result[str] = {name: this.statisticsNames[i], value: pc.median(data)}
                    break

                case 'Q1':
                    result[str] = {name: this.statisticsNames[i], value: pc.firstQuartile(data)}
                    break

                case 'Q3':
                    result[str] = {name: this.statisticsNames[i], value: pc.thirdQuartile(data)}
                    break

                case 'outliers':
                    result[str] = {name: this.statisticsNames[i], value: pc.getOutliers(data)}
                    break

                default:
                    console.error(`Cannot calculate the statistical property called: ${str}`)
                    break
            }
        }
        return result
    },

    // Get the percentiles from 0 to 100
    // Arg:
    // data: array containing the data to calculate stats from
    getAllPercentiles: function (data) {
        let result = {}
        for (let i = 5; i <= 95; i += 5) {
            result[i] = pc.percentile(data, i)
        }
        return result
    }
}

window.basestats = main;
