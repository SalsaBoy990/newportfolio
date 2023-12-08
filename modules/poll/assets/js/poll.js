/**
 *
 * Get poll data
 *
 */
function pollData() {

    return {
        votes: [],
        errorMessage: '',

        getVotes(apiPath) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', apiPath);
            xhr.send();

            xhr.onreadystatechange = () => {
                // successful
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.response);
                    const votes = JSON.parse(xhr.response);

                    // GOOGLE CHART
                    // Load the Visualization API and the corechart package.
                    google.charts.load('current', {'packages': ['corechart']});

                    // Set a callback to run when the Google Visualization API is loaded.
                    google.charts.setOnLoadCallback(drawChart);


                    // Callback that creates and populates a data table,
                    // instantiates the bar chart, passes in the data and
                    // draws it.
                    function drawChart() {
                        // Create the data table.
                        const chartData = new google.visualization.DataTable();
                        chartData.addColumn('string', 'Szerver oldali nyelv');
                        chartData.addColumn('number', 'Szavazatok száma');

                        for (let index in votes) {
                            console.log([index, votes[index]]);
                            chartData.addRow([index, votes[index]])
                        }

                        // Set chart options
                        const options = {
                            'title': 'A szavazás eredménye',
                            'width': 500,
                            'height': 500,
                            'legend': 'bottom'
                        };

                        // Instantiate and draw our chart, passing in some options.
                        const chart = new google.visualization.BarChart(document.getElementById('voteForm'));
                        chart.draw(chartData, options);
                    }
                }
            }
        },

    };

}

document.addEventListener('alpine:init', () => {
    Alpine.data('pollData', pollData);
});
