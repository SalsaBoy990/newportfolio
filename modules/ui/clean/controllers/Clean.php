<?php

class Clean extends Trongate
{
	private string $template_to_use = 'clean_demo';

    function __construct() {
        parent::__construct();
        $this->parent_module = 'documentation';
        $this->child_module = 'clean';
    }

    function index() {
        $data['view_module'] = 'ui/clean';
        $data['view_file'] = 'index';

		// SEO
		$data['title'] = 'Clean UI Components';
		$data['description'] = 'UI Components for Clean CSS and JS library';

        $this->template($this->template_to_use, $data);
    }

    function __destruct() {
        $this->parent_module = '';
        $this->child_module = '';
    }
}
