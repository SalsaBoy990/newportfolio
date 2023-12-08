<?php

class Ui extends Trongate
{
	private string $template_to_use = 'clean';

    function index()
    {
        $data['view_module'] = 'ui/clean';
        $data['view_file'] = 'index';

	    $data['title'] = 'Clean UI Components';
	    $data['description'] = 'UI Components for Clean CSS and JS library';

        $this->template($this->template_to_use, $data);
    }
}
