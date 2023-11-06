<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="card">
    <div class="card-heading">
        Skill Details
    </div>
    <div class="card-body">
        <?php
        echo form_open($form_location);
        echo form_label('Title');
        echo form_input('title', $title, array("placeholder" => "Enter Title"));

        echo form_label('language');
        echo form_dropdown('language', get_language_list(), $language ?? get_language());

        echo form_label('Content');
        echo form_textarea('content', $content, array("placeholder" => "Enter Content", "id" => "skill-content-area"));

        echo form_label('Background color');
        echo form_dropdown('bg_color', $colors, $bg_color ?? $default_color);

        echo form_label('Created At <span>(optional)</span>');
        $attr = array("class" => "datetime-picker", "autocomplete" => "off", "placeholder" => "Select Created At");
        echo form_input('created_at', $created_at, $attr);

        echo form_submit('submit', 'Submit');
        echo anchor($cancel_url, 'Cancel', array('class' => 'button alt'));
        echo form_close();
        ?>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="admin_skills_module/css/admin_skills.css">
