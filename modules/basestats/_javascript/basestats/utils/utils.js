// general and percentile utils
const utils = {

    // Determines if x is an integer.
    isInteger: function (x) {
        return Math.round(x) === x
    },

    // Is object type an "Array"?
    isArray: function (o) {
        return classOf(o) === 'Array'
    },


    // Orders array elements in ascending order.
    ascendingOrder: function (arr) {
        return arr.sort(function (a, b) {
            return a - b
        })
    },

    // Creates rank array for the sorted array.
    createRankArray: function (length) {
        let arr = []
        for (let i = 1; i <= length; i++) {
            arr.push(i)
        }
        return arr
    },

    // Calculates the rank of the percentile.
    getPercentileRank: function (p, n) {
        return (p / 100) * (n + 1)
    },

    // Calculates the value of the percentile.
    getPercentileValue: function (decimalPart, smallerValue, biggerValue) {
        return decimalPart * (biggerValue - smallerValue) + smallerValue
    }
}

// classOf function to determine the object type (Object, Array, Function)
function classOf(o) {
    if (o === null) {
        return 'Null'
    }
    if (o === undefined) {
        return 'Undefined'
    }
    return Object.prototype.toString.call(o).slice(8, -1)
}

export default utils;
