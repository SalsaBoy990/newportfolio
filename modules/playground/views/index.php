<div class="frontpage">
    <h1>My Simple Custom Trongate Modules</h1>
    <ul>
        <?php foreach ($pages as $name => $slug) { ?>
            <li>
                <a href="<?= BASE_URL . $slug ?>">
                    <?= $name ?>
                </a>
            </li>
        <?php } ?>
        <li>
            <a href="invoice/print_pdf" download="">Print a DUMMY PDF with Dompdf</a>
        </li>
    </ul>
</div>
