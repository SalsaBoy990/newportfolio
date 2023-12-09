<?php

/**
 * Controller for my public portfolio
 *
 */
class Frontpage extends Trongate
{
    private array $translations;

    /**
     * @var FrontService
     */
    private FrontService $front_service;


    public function __construct(?string $module_name = null)
    {
        parent::__construct($module_name);

        // get translations
        $t = [];
        require_once __DIR__.'/../languages/'.get_language().'/front.php';
        $this->translations = $t;

        // initialize model service
        require_once __DIR__.'/../services/FrontService.php';
        $this->front_service = new FrontService();

    }


    /**
     * The frontpage showcasing my portfolio
     *
     * @return void
     * @throws Exception
     */
    public function index(): void
    {
        $data                = $this->translations;
        $data['view_module'] = 'frontpage';
        $data['view_file']   = 'frontpage';

        $data['languages'] = get_language_list();
        $data['language']  = get_language();

        $data['email_address'] = $this->front_service->get_email_address();
        $data['phone_number']  = $this->front_service->get_phone_number();
        $data['github_link']   = $this->front_service->get_github_link();

        $data['skills'] = $this->front_service->get_skills(get_language());
        $data['projects'] = $this->front_service->get_projects(get_language());

        $this->template('frontpage', $data);
    }

}
