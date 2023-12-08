(() => {
  // modules/basestats/_javascript/basestats/modules/base.js
  var base = {
    sum,
    square,
    min,
    max,
    amean,
    variance,
    stdev
  };
  function sum(x, y) {
    return x + y;
  }
  function square(x) {
    return x * x;
  }
  function min(x, y) {
    return x < y ? x : y;
  }
  function max(x, y) {
    return x > y ? x : y;
  }
  function amean(data) {
    return data.reduce(sum, 0) / data.length;
  }
  function variance(data) {
    let mean = amean(data);
    let deviations = data.map(function(x) {
      return x - mean;
    });
    return deviations.map(square).reduce(sum, 0) / (data.length - 1);
  }
  function stdev(data) {
    return Math.sqrt(variance(data));
  }
  var base_default = base;

  // modules/basestats/_javascript/basestats/utils/utils.js
  var utils = {
    // Determines if x is an integer.
    isInteger: function(x) {
      return Math.round(x) === x;
    },
    // Is object type an "Array"?
    isArray: function(o) {
      return classOf(o) === "Array";
    },
    // Orders array elements in ascending order.
    ascendingOrder: function(arr) {
      return arr.sort(function(a, b) {
        return a - b;
      });
    },
    // Creates rank array for the sorted array.
    createRankArray: function(length) {
      let arr = [];
      for (let i = 1; i <= length; i++) {
        arr.push(i);
      }
      return arr;
    },
    // Calculates the rank of the percentile.
    getPercentileRank: function(p, n) {
      return p / 100 * (n + 1);
    },
    // Calculates the value of the percentile.
    getPercentileValue: function(decimalPart, smallerValue, biggerValue) {
      return decimalPart * (biggerValue - smallerValue) + smallerValue;
    }
  };
  function classOf(o) {
    if (o === null) {
      return "Null";
    }
    if (o === void 0) {
      return "Undefined";
    }
    return Object.prototype.toString.call(o).slice(8, -1);
  }
  var utils_default = utils;

  // modules/basestats/_javascript/basestats/modules/percentile.js
  var percentile = {
    getOutliers,
    percentile: getPercentile,
    firstQuartile,
    median,
    thirdQuartile
  };
  function getPercentile(arr, p) {
    let n = arr.length;
    let values = utils_default.ascendingOrder(arr);
    let ranks = utils_default.createRankArray(n);
    let percentileRank = utils_default.getPercentileRank(p, n);
    if (utils_default.isInteger(percentileRank)) {
      for (let i = 0; i < n; i++) {
        if (ranks[i] === percentileRank) {
          return values[i];
        }
      }
    } else {
      let integerPart = Math.trunc(percentileRank);
      let decimalPart = percentileRank - integerPart;
      let smallerValue;
      let biggerValue;
      for (let i = 0; i < n; i++) {
        if (ranks[i] === integerPart) {
          smallerValue = values[i];
          biggerValue = values[i + 1];
          break;
        }
      }
      return utils_default.getPercentileValue(decimalPart, smallerValue, biggerValue);
    }
  }
  function firstQuartile(arr) {
    return getPercentile(arr, 25);
  }
  function median(arr) {
    return getPercentile(arr, 50);
  }
  function thirdQuartile(arr) {
    return getPercentile(arr, 75);
  }
  function getOutliers(arr) {
    let n = arr.length;
    let limits = lowerAndUpperLimits(arr);
    let outliers = [];
    for (let i = 0; i < n; i++) {
      if (arr[i] > limits.upperLimit) {
        outliers.push(arr[i]);
      } else if (arr[i] < limits.lowerLimit) {
        outliers.push(arr[i]);
      }
    }
    return utils_default.ascendingOrder(outliers);
  }
  function lowerAndUpperLimits(arr) {
    let Q3 = thirdQuartile(arr);
    let Q1 = firstQuartile(arr);
    let IQR = Q3 - Q1;
    let upperLimit = Q3 + 1.5 * IQR;
    let lowerLimit = Q1 - 1.5 * IQR;
    return {
      lowerLimit,
      upperLimit
    };
  }
  var percentile_default = percentile;

  // modules/basestats/_javascript/basestats/modules/props.js
  var statistics = [
    "min",
    "max",
    "sum",
    "amean",
    // arithmetic mean
    "Q1",
    "median",
    "Q3",
    "outliers",
    "variance",
    "stdev"
  ];
  var statisticsNames = [
    "Minimum",
    "Maximum",
    "\xD6sszeg",
    "Sz\xE1mtani \xE1tlag",
    "1. kvartilis (25%)",
    "Medi\xE1n",
    "3. kvartilis (75%)",
    "Kiugr\xF3 \xE9rt\xE9kek",
    "Variancia",
    "Sz\xF3r\xE1s"
  ];

  // modules/basestats/_javascript/basestats/main.js
  var main = {
    // Array of statistical properties that you can currently calculate
    statistics,
    statisticsNames,
    // Calculate basic statistical properties
    // Args:
    // stats: array containing the stats to calculate see the 'vars' property above
    // data: array containing the data to calculate stats from
    // error handling needs enhancements...
    getStats: function(data) {
      if (arguments.length < 1) {
        throw new Error("You did not supply all the arguments.");
      }
      if (!utils_default.isArray(this.statistics) || !utils_default.isArray(data)) {
        throw new Error("Arguments of array type needed.");
      }
      let result = {};
      let str;
      for (let i = 0; i < this.statistics.length; i++) {
        switch (str = this.statistics[i]) {
          case "sum":
            result[str] = { name: this.statisticsNames[i], value: data.reduce(base_default.sum, 0) };
            break;
          case "min":
            result[str] = { name: this.statisticsNames[i], value: data.reduce(base_default.min) };
            break;
          case "max":
            result[str] = { name: this.statisticsNames[i], value: data.reduce(base_default.max) };
            break;
          case "amean":
            result[str] = { name: this.statisticsNames[i], value: base_default.amean(data) };
            break;
          case "variance":
            result[str] = { name: this.statisticsNames[i], value: base_default.variance(data) };
            break;
          case "stdev":
            result[str] = { name: this.statisticsNames[i], value: base_default.stdev(data) };
            break;
          case "median":
            result[str] = { name: this.statisticsNames[i], value: percentile_default.median(data) };
            break;
          case "Q1":
            result[str] = { name: this.statisticsNames[i], value: percentile_default.firstQuartile(data) };
            break;
          case "Q3":
            result[str] = { name: this.statisticsNames[i], value: percentile_default.thirdQuartile(data) };
            break;
          case "outliers":
            result[str] = { name: this.statisticsNames[i], value: percentile_default.getOutliers(data) };
            break;
          default:
            console.error(`Cannot calculate the statistical property called: ${str}`);
            break;
        }
      }
      return result;
    },
    // Get the percentiles from 0 to 100
    // Arg:
    // data: array containing the data to calculate stats from
    getAllPercentiles: function(data) {
      let result = {};
      for (let i = 5; i <= 95; i += 5) {
        result[i] = percentile_default.percentile(data, i);
      }
      return result;
    }
  };
  window.basestats = main;
})();
//# sourceMappingURL=main.js.map
