<h1><?= $headline ?></h1>
<?= validation_errors() ?>
<div class="card">
    <div class="card-heading">
        Project Details
    </div>
    <div class="card-body">
        <?php
        echo form_open_upload($form_location);
        echo form_label('Title');
        echo form_input('title', $title, array("placeholder" => "Enter Title"));

        echo form_label('language');
        echo form_dropdown('language', get_language_list(), $language ?? get_language());

        echo form_label('Client');
        echo form_input('client', $client, array("placeholder" => "Enter Client"));

        echo form_label('Content');
        echo form_textarea('content', $content,
            array("placeholder" => "Enter Content", "id" => "post-content-area"));

        echo form_label('Links');
        echo form_textarea('links', $links, array("placeholder" => "Enter Links", "id" => "project-link-content-area"));

        echo form_label('Order');
        echo form_number('order', $order ?? 0);

        echo form_label('Cover image');
        echo form_file_select('cover_image');
        if (isset($cover_image) && $cover_image !== '') { ?>
            <br>
            <img class="admin-cover-preview" src="<?= BASE_URL.$cover_image ?>" alt="<?= $title ?>">
        <?php }

        echo form_label('Created At <span>(optional)</span>');
        $attr = array("class" => "datetime-picker", "autocomplete" => "off", "placeholder" => "Select Created At");
        echo form_input('created_at', $created_at, $attr);

        echo form_submit('submit', 'Submit');
        echo anchor($cancel_url, 'Cancel', array('class' => 'button alt'));
        echo form_close();
        ?>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="admin_projects_module/css/admin_projects.css">

