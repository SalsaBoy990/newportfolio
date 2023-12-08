<?php

$links = [
	'Home' => [
         'url' => BASE_URL,
         'icon' => 'fa fa-home',
    ],

	'Entries' => [
		'url' => BASE_URL . 'entries',
		'icon' => 'fa fa-solid fa-book',
	],

	'PWD Generator' => [
		'url' => BASE_URL . 'password_generator',
		'icon' => 'fa fa-lock',
	],

	'Get In Touch' => [
		'url' => BASE_URL . 'mailer/contact',
		'icon' => 'fa fa-solid fa-envelope',
	],

	'Clean CSS' => [
		'url' => BASE_URL . 'clean',
		'icon' => 'fa fa-solid fa-layer-group',
	],

];


foreach ($links as $title => $values) { ?>
    <li><a href="<?= $values['url'] ?>" <?= is_active_link($values['url']) ? 'aria-current="page"' : '' ?> class="<?= is_active_link($values['url'])  ? 'active' : '' ?>">
            <i class="<?= $values['icon'] ?>"></i>
            <?= $title ?>
        </a>
    </li>
<?php } ?>

