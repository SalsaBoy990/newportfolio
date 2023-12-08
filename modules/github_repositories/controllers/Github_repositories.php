<?php

final class Github_repositories extends Trongate
{
    private const SORT = 'stars';
    private const ORDER = 'desc';
    private const PER_PAGE = 10;

    private string $api_url;
    private string $search_term;
	private string $template_to_use = 'clean_narrow';

    public function __construct($module_name = null)
    {
        parent::__construct($module_name);

        $this->api_url = 'https://api.github.com/search/repositories';
        $this->search_term = 'php';
    }

    function index(): void
    {
        // Todo: tokens are not working yet! Do not use this module in production.
        $this->module('trongate_tokens');
        $token = $this->trongate_tokens->_attempt_get_valid_token();


        $data['view_file'] = 'index';
        $data['token'] = $token;
        $this->template($this->template_to_use, $data);
    }

    function repositories()
    {
        api_auth();

        $this->module('a-api_helper');
        $params = $this->api_helper->_get_params_from_url(3);

        extract($params);

        // Sanitize url
        $this->search_term = filter_var($search_term, FILTER_SANITIZE_URL);
        $this->search_term = strtolower($this->search_term);
        $results = $this->_get_github_repositories();

        echo json_encode($results);
        die;
    }

    private function _get_github_repositories()
    {
        $parts = [
            '?q=', $this->search_term,
            '+language:', $this->search_term,
            '&sort=', self::SORT,
            '&order=', self::ORDER,
            '&per_page=', self::PER_PAGE
        ];
        $this->api_url .= implode('', $parts);


        // Initializes a new cURL session
        $curl = curl_init($this->api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'User-Agent: Salsaboy990',
        ]);
        // Execute cURL request
        $response = curl_exec($curl);
        // Close cURL session
        curl_close($curl);

        return $response;
    }


}
