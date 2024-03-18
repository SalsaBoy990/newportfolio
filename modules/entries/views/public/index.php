<div class="entries">
    <h1>All Entries</h1>
    <nav>
        <?php if (count($entries) > 0) {
            foreach ($entries as $entry) { ?>
                <h3 class="fs-24"><?= anchor('entry/'.$entry->url_string, $entry->title) ?></h3>
                <?php
            }
        } else { ?>
            <p>There are no entries yet.</p>
        <?php } ?>
    </nav>
</div>



