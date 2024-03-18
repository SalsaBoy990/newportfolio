<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guitar Information</title>

    <link rel="stylesheet" href="guitar_module/css/custom.css">

</head>
<body>
<section class="container">
    <h1><?= $guitar_title ?></h1>
    <p><img style="width: 300px" src="guitar_module/images/telecaster.jpg" alt="Fender Telecaster"></p>

    <p>The Fender Telecaster, colloquially known as the Tele, is, an
        electric guitar produced by Fender. Together with its sister model the
        Esquire, it is the world's first mass-produced, commercially successful
        solid-body electric guitar. Its simple yet effective design and
        revolutionary sound broke ground and set trends in electric guitar
        manufacturing and popular music.</p>

    <p>Introduced for national distribution as the Broadcaster in the
        autumn of 1950 as a two-pickup version of its sister model, the
        single-pickup Esquire, the pair were the first guitars of their kind
        manufactured on a substantial scale. A trademark conflict with a rival
        manufacturer (Gretsch Broadkaster) led to the guitar being renamed in
        1951. Initially, the Broadcaster name was simply cut off of the labels
        placed on the guitars (leading to a limited run of nameless guitars known
        as "No-casters") and later in 1951, the final name of Telecaster was
        applied to the guitar to take advantage of the advent of television. The
        Telecaster quickly became a popular model, and has remained in
        continuous production since its first incarnation.</p>


    <p>(Source: <?= anchor('https://en.wikipedia.org/wiki/Fender_Telecaster', 'Wikipedia') ?>)</p>
</section>
<style>
    .container {
        margin: 0 auto;
        max-width: 760px;
    }
</style>
<script src="guitar_module/js/custom.js"></script>
</body>
</html>
