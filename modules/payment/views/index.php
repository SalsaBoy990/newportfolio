<section class="payment">

    <h2>Simple Payment Form</h2>
    <hr>

    <?php flashdata('<div class="alert success">', '</div>'); ?>
    <?= Modules::run('form_validator/_validation_errors') ?>

    <?php
    echo form_open($form_location);


    echo form_label('Card number *', ['for' => "card_number"]); ?>
    <input class="content-300 <?= Modules::run('form_validator/_has_error', 'card_number') ? 'border border-red' : '' ?>"
           type="text" name="card_number" value="<?= set_value_or_default($card_number, '4242 4242 4242 4242') ?>"
           inputmode="numeric"
           aria-label="credit card number"
           placeholder="4242 4242 4242 4242">
    <?php if (Modules::run('form_validator/_has_error', 'card_number')) { ?>
        <p class="fs-14 text-red margin-top-0"><?= Modules::run('form_validator/_get_error', 'card_number') ?></p>
    <?php } ?>


    <p class="margin-bottom-0-5 margin-top-1-5"><b>Expiration date</b></p>

    <div class="expiration-date content-300">
        <div>
            <label for="month"
                   class="margin-top-0 <?= Modules::run('form_validator/_has_error', 'month') ? 'text-red' : '' ?>">Month
                *</label>
            <input type="text" name="month" placeholder="MM" value="<?= set_value_or_default($month, '12') ?>"
                   inputmode="numeric" aria-label="credit card expiration month"
                   class="<?= Modules::run('form_validator/_has_error', 'month') ? 'border border-red' : '' ?>"
            >
        </div>
        <div>
            <label for="year"
                   class="margin-top-0 <?= Modules::run('form_validator/_has_error', 'year') ? 'text-red' : '' ?>">Year
                *</label>
            <input type="text" name="year" placeholder="YY" value="<?= set_value_or_default($year, '25') ?>"
                   inputmode="numeric" aria-label="credit card expiration year"
                   class="<?= Modules::run('form_validator/_has_error', 'year') ? 'border border-red' : '' ?>"
            >
        </div>
        <div>
            <label for="cvv"
                   class="margin-top-0 <?= Modules::run('form_validator/_has_error', 'cvv') ? 'text-red' : '' ?>">CVV
                *</label>
            <input type="text" name="cvv" value="<?= set_value_or_default($cvv, '123') ?>"
                   inputmode="numeric" aria-label="CVV security code"
                   class="<?= Modules::run('form_validator/_has_error', 'cvv') ? 'border border-red' : '' ?>"
            >
        </div>
    </div>


    <?php
    echo form_label('Name on the card *', ['for' => 'full_name']);
    echo form_input('full_name', set_value_or_default($full_name, 'Teszt Elek'), [
        'class' => 'content-300 '.(Modules::run('form_validator/_has_error', 'full_name') ? 'border border-red' : ''),
        'aria-label' => 'name on the card'
    ]);
    if (Modules::run('form_validator/_has_error', 'full_name')) { ?>
        <p class="fs-14 text-red margin-top-0"><?= Modules::run('form_validator/_get_error', 'full_name') ?></p>
    <?php } ?>

    <?php
    echo form_label('Your email address *', ['for' => 'email_address']);
    echo form_email('email_address', set_value_or_default($email_address, 'example123@gmail.com'), [
        'class' => 'content-300 '.(Modules::run('form_validator/_has_error', 'email_address') ? 'border border-red' : ''),
        'aria-label' => 'your email address'
    ]);
    if (Modules::run('form_validator/_has_error', 'email_address')) { ?>
        <p class="fs-14 text-red margin-top-0"><?= Modules::run('form_validator/_get_error', 'email_address') ?></p>
    <?php } ?>


    <?php
    echo form_label('Choose currency to convert to *', ['for' => 'currency_id']);
    echo form_dropdown('currency_id', $currency_options, $currency_id, [
        'class' => 'content-300 '.(Modules::run('form_validator/_has_error', 'currency_id') ? 'border border-red' : '')
    ]);
    if (Modules::run('form_validator/_has_error', 'currency')) { ?>
        <p class="fs-14 text-red margin-top-0"><?= Modules::run('form_validator/_get_error', 'currency') ?></p>
    <?php } ?>


    <?php
    echo form_label('Amount to pay (HUF) *', ['for' => 'amount']);
    echo form_number('amount', set_value_or_default($amount, 150000), [
        'class' => 'content-300 '.(Modules::run('form_validator/_has_error', 'amount') ? 'border border-red' : ''),
        'placeholder' => '1',
        'inputmode' => 'numeric',
        'aria-label' => 'amount to pay in HUF'
    ]);
    if (Modules::run('form_validator/_has_error', 'amount')) { ?>
        <p class="fs-14 text-red margin-top-0"><?= Modules::run('form_validator/_get_error', 'amount') ?></p>
    <?php } ?>

    <br>

    <?php
    echo form_submit('submit', 'Send Money!');
    echo form_close();
    ?>

    <div class="box">
        <?php flashdata('<div class="alert success">', '</div>'); ?>
    </div>

</section>

<?php Modules::run('form_validator/_clear_validation_errors'); ?>

<link rel="stylesheet" type="text/css" href="payment_module/css/payment.css">
<script type="text/javascript" src="payment_module/js/payment.js"></script>
