<h1><?= $headline ?></h1>
<?php
flashdata();
echo '<p>'.anchor('entries/create', 'Create New Entry Record', array("class" => "button"));
if (strtolower(ENV) === 'dev') {
    echo anchor('api/explorer/entries', 'API Explorer', array("class" => "button alt"));
}
echo '</p>';
echo Pagination::display($pagination_data);
if (count($rows) > 0) { ?>
    <table id="results-tbl">
        <thead>
        <tr>
            <th colspan="5">
                <div>
                    <div><?php
                        echo form_open('entries/manage/1/', array("method" => "get"));
                        echo form_input('searchphrase', '', array("placeholder" => "Search records..."));
                        echo form_submit('submit', 'Search', array("class" => "alt"));
                        echo form_close();
                        ?></div>
                    <div>Records Per Page: <?php
                        $dropdown_attr['onchange'] = 'setPerPage()';
                        echo form_dropdown('per_page', $per_page_options, $selected_per_page, $dropdown_attr);
                        ?></div>

                </div>
            </th>
        </tr>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Created At</th>
            <th style="width: 20px;">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $attr['class'] = 'button alt';
        foreach ($rows as $row) { ?>
            <tr>
                <td><?= $row->title ?></td>
                <td><?= str_split(strip_tags($row->content), 80)[0].'...' ?></td>
                <td><?= date('l jS F Y \a\t H:i', strtotime($row->created_at)) ?></td>
                <td><?= anchor('entries/show/'.$row->id, 'View', $attr) ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    if (count($rows) > 9) {
        unset($pagination_data['include_showing_statement']);
        echo Pagination::display($pagination_data);
    }
}
?>
