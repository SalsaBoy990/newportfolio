<style>
    .contact-form .content-400 {
        max-width: 400px;
        width: 100%;
    }
</style>

<section class="contact-form">

    <h1>Contact Us form</h1>

    <small>Required fields have denoted with *</small>

    <div class="content-400">
        <?php

        echo form_open($form_location);

        echo form_label('Your Name *', ['for' => 'name']);
        echo form_input('name',
            set_value_or_default($name, ''),
            ['class' => Modules::run('a-validate/_has_error', 'name') ? 'border border-red' : ($name ? 'border border-green' : '')]
        );
        if (Modules::run('a-validate/_has_error', 'name')) { ?>
            <p class="fs-14 text-red margin-top-0"><?= Modules::run('a-validate/_get_error', 'name') ?></p>
        <?php } ?>

        <?php
        echo form_label('Your Email *', ['for' => 'email']);
        echo form_email('email',
            set_value_or_default($email, ''),
            ['class' => Modules::run('a-validate/_has_error', 'email') ? 'border border-red' : ($email ? 'border border-green' : '')]
        );
        if (Modules::run('a-validate/_has_error', 'email')) { ?>
            <p class="fs-14 text-red margin-top-0"><?= Modules::run('a-validate/_get_error', 'email') ?></p>
        <?php } ?>

        <?php
        echo form_label('Subject *', ['for' => 'subject']);
        echo form_input('subject',
            set_value_or_default($subject, ''),
            ['class' => Modules::run('a-validate/_has_error', 'subject') ? 'border border-red' : ($subject ? 'border border-green' : '')]
        );
        if (Modules::run('a-validate/_has_error', 'subject')) { ?>
            <p class="fs-14 text-red margin-top-0"><?= Modules::run('a-validate/_get_error', 'subject') ?></p>
        <?php } ?>

        <?php
        echo form_label('Message *', ['for' => 'message']);
        echo form_textarea('message',
            set_value_or_default($message, ''),
            ['class' => Modules::run('a-validate/_has_error', 'message') ? 'border border-red' : ($message ? 'border border-green' : '')]
        );
        if (Modules::run('a-validate/_has_error', 'message')) { ?>
            <p class="fs-14 text-red margin-top-0"><?= Modules::run('a-validate/_get_error', 'message') ?></p>
        <?php } ?>

        <?php
        flashdata('<div class="panel success">', '</div>');

        echo form_submit('submit', 'Submit');
        echo form_close();

        ?>
    </div>
</section>

<?php Modules::run('a-validate/_clear_validation_errors'); ?>

