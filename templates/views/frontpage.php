<!DOCTYPE html>
<html lang="<?= $data['language'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $data['text_name'] ?></title>

    <!-- Metas for social media -->
    <meta name="description" content="<?= $data['text_meta_description'] ?>"/>
    <meta property="og:title" content="<?= $data['text_meta_title'] ?>"/>
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content="<?= $data['text_meta_site_name'] ?>"/>
    <meta property="og:description" content="<?= $data['text_meta_description'] ?>"/>
    <meta property="og:image" content=""/>
    <meta property="og:type" content="website"/>

    <!-- Twitter -->
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="<?= $data['text_meta_title'] ?>"/>
    <meta name="twitter:creator" content="<?= $data['text_meta_site_name'] ?>"/>
    <meta name="twitter:title" content="<?= $data['text_meta_title'] ?>"/>
    <meta name="twitter:description" content="<?= $data['text_meta_description'] ?>"/>
    <meta name="twitter:url" content=""/>
    <meta name="twitter:image" content=""/>

    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= BASE_URL?>/favicon-16x16.png">
    <link rel="manifest" href="<?= BASE_URL?>/site.webmanifest">
    <link rel="mask-icon" href="<?= BASE_URL?>/safari-pinned-tab.svg" color="#5b71d5">
    <meta name="apple-mobile-web-app-title" content="Andr&aacute;s Gul&aacute;csi's Portfolio">
    <meta name="application-name" content="Andr&aacute;s Gul&aacute;csi's Portfolio">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <script>
        var newLanguage = '<?= $data['language'] ?>';
        var oldLanguage = localStorage.getItem('language');
        if (!oldLanguage || oldLanguage !== newLanguage) {
            localStorage.setItem('language', newLanguage);
            oldLanguage = newLanguage;
        }

        fetch('http://localhost/portfolio/localization/test', {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify({language: oldLanguage})
        })
            .then(function (res) {
                console.log(res)
            })
            .catch(function (res) {
                console.log(res)
            });

    </script>

    <link rel="stylesheet" type="text/css" href="frontpage_module/css/frontpage.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="frontpage_module/js/frontpage.js" type="text/javascript"></script>

</head>

<body class="front-page black-body">
<div id="top"></div>
<div class="h-10 hidden">
    <div class="text-center leading-8 hidden-menu">
    </div>
</div>

<div class="frontpage-content">
    <?= Template::display($data) ?>
</div>

</body>
</html>
