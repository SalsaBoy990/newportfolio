<?php

class Poll extends Trongate
{
    /**
     * @var PollService
     */
    private PollService $poll_service;


    public function __construct(?string $module_name = null)
    {
        require_once __DIR__.'/../services/PollService.php';
        $this->poll_service = new PollService();
        parent::__construct($module_name);
    }


    /**
     * @return void
     * @throws Exception
     */
    function index(): void
    {
        $data['view_file'] = 'index';
        $data['votes']     = $this->poll_service->_read_data_from_csv();
        $data['api_path']  = BASE_URL.'poll/votes';
        $this->template('clean', $data);
    }


    /**
     * @return void
     */
    public function votes(): void
    {
        $votes = $this->poll_service->_read_data_from_csv();

        echo json_encode($votes);
        die;
    }


}
