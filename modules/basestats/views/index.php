<!-- Inspired by https://codepen.io/adam-gora/pen/YZmPEB -->
<section x-data="baseStatsData">
    <h1>Base statistics module</h1>
    <?= json($test).'>' ?>

    <button @click="getDataFromCSV('<?= BASE_URL ?>' + 'basestats/stats/')">Get Stats</button>

    <div class="row-padding" x-show="isDataReady">
        <div class="half">
            <h2>Basic statistics</h2>
            <table>
                <thead>
                <tr>
                    <th>Measure</th>
                    <th>Value</th>
                </tr>
                </thead>

                <tbody>
                <template x-for="(stat, index) in baseStats">
                    <tr>
                        <td x-text="stat.name"></td>
                        <td x-text="stat !== undefined && stat.value"></td>
                    </tr>
                </template>

                </tbody>
            </table>

        </div>
        <div class="half">
            <h2>Percentiles</h2>
            <table class="fs-14">
                <thead>
                <tr>
                    <th>X percentile</th>
                    <th>Value</th>
                </tr>
                </thead>

                <tbody>
                <template x-for="(percentile, index) in percentileStats">
                    <tr>
                        <td x-text="index"></td>
                        <td x-text="percentile !== undefined && percentile"></td>
                    </tr>
                </template>

                </tbody>
            </table>
        </div>
    </div>


</section>

<script src="basestats_module/js/main.js" type="text/javascript"></script>
<script src="basestats_module/js/basestats.js" type="text/javascript"></script>
