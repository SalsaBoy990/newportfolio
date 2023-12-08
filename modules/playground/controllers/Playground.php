<?php

use services\MyPages;

class Playground extends Trongate
{
    private array $pages;

    private string $template_to_use = 'clean_narrow';

    public function __construct( $module_name = null ) {
        parent::__construct( $module_name );

        require_once __DIR__.'/../services/MyPages.php';

        $this->pages = (new MyPages())->get_my_pages();
    }

    function index() {

        $data['view_module'] = 'playground';
        $data['view_file']   = 'index';
        $data['title']       = 'Gulácsi András - test website';
        $data['description'] = 'Gulácsi András - test website';

        $data['pages'] = $this->pages;

        $this->template($this->template_to_use, $data );
    }
}
