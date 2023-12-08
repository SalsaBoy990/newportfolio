<h1>Simple Image Upload</h1>

<h2>Képfeltöltés</h2>

<?= Modules::run('a-validate/_validation_errors') ?>

<?php

echo form_open($form_location, ['id' => 'simple-image-form', 'method' => 'post', 'enctype' => 'multipart/form-data']);

echo form_label('Kép feltöltése', ['for' => 'image']);
echo form_file_select('image');

echo form_label('Kép címe', ['for' => 'title']);
echo form_input('title', '', ['type' => 'file', 'placeholder' => 'pl. A rőzsehordó asszony']);

echo form_submit('submit', 'Feltölt', ['class' => 'button']);

echo form_close();
?>

<hr>

<?php Modules::run('a-validate/_clear_validation_errors'); ?>
