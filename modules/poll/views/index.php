<style>

    .poll label {
        display: inline-block;
        margin-right: 0.5em;
    }

</style>

<section x-data="pollData" class="poll">

    <h1>Poll with Google bar chart</h1>

    <?= json($votes); ?>

    <h2>Melyik a legjobb szerver oldali nyelv ezek közül?</h2>


    <?php flashdata('<div class="alert success">', '</div>'); ?>

    <?php

    echo form_open(BASE_URL.'poll/votes', ['method' => 'post']);

    echo form_radio('vote', 'Trongate');
    echo form_label('Trongate', ['for' => 'Trongate']);

    echo form_radio('vote', 'Laravel');
    echo form_label('Laravel', ['for' => 'Laravel']);

    echo form_radio('vote', 'Symfony');
    echo form_label('Symfony', ['for' => 'Symfony']);

    echo form_radio('vote', 'CodeIgniter');
    echo form_label('CodeIgniter', ['for' => 'CodeIgniter']);

    echo form_radio('vote', 'Lumen');
    echo form_label('Lumen', ['for' => 'Lumen']);

    echo form_radio('vote', 'Laminas');
    echo form_label('Laminas', ['for' => 'Laminas']);

    echo form_radio('vote', 'Phalcon');
    echo form_label('Phalcon', ['for' => 'Phalcon']);

    echo form_radio('vote', 'CakePHP');
    echo form_label('CakePHP', ['for' => 'CakePHP']);

    echo form_radio('vote', 'Yii');
    echo form_label('Yii', ['for' => 'Yii']);

    echo form_radio('vote', 'Zend');
    echo form_label('Zend', ['for' => 'Zend']);

    echo '<br>';
    echo form_submit('submit', 'Vote');

    echo form_close();

    ?>

    <button class="alt" @click="getVotes('<?= $api_path ?>')">Show votes</button>
    <div id="voteForm"></div>
</section>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="poll_module/js/poll.js"></script>
