<?php

class Admin_projects extends Trongate
{
    /**
     * @var array
     */
    private array $translations;


    /**
     * To sanitize user input from TinyMCE text editor
     * Usage: $clean_html = $this->purifier->purify($dirty_html);
     *
     * @var HTMLPurifier
     */
    private HTMLPurifier $purifier;


    /**
     * @var Projects
     */
    private Projects $projects;

    private $default_limit = 20;
    private $per_page_options = array(10, 20, 50, 100);


    public function __construct(?string $module_name = null)
    {
        parent::__construct($module_name);

        $this->purifier = new HTMLPurifier();

        require_once __DIR__.'/../services/Projects.php';
        $this->projects = new Projects();

        // get translations
        $translations = [];
        require_once __DIR__.'/../languages/'.get_language().'/projects.php';
        $this->translations = $translations;
    }


    /**
     * @return void
     * @throws ReflectionException
     */
    function create(): void
    {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $update_id = (int) segment(3);
        $submit    = post('submit');

        if (($submit == '') && ($update_id > 0)) {
            $data = $this->_get_data_from_db($update_id);
        } else {
            $data = $this->_get_data_from_post();
        }

        if ($update_id > 0) {
            $data['headline']   = 'Update Project Record';
            $data['cancel_url'] = BASE_URL.'admin_projects/show/'.$update_id;
        } else {
            $data['headline']   = 'Create New Project Record';
            $data['cancel_url'] = BASE_URL.'admin_projects/manage';
        }

        $data['form_location'] = BASE_URL.'admin_projects/submit/'.$update_id;
        $data['view_file']     = 'create';
        $this->template('admin', $data);
    }


    /**
     * @return void
     * @throws ReflectionException
     */
    function manage(): void
    {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        if (segment(4) !== '') {
            $data['headline'] = 'Search Results';
            $searchphrase     = trim($_GET['searchphrase']);
            $params['title']  = '%'.$searchphrase.'%';
            $sql              = 'select * from projects
            WHERE title LIKE :title
            ORDER BY id';
            $all_rows         = $this->model->query_bind($sql, $params, 'object');
        } else {
            $data['headline'] = 'Manage Projects';
            $all_rows         = $this->model->get('id', 'projects');
        }

        $pagination_data['total_rows']                = count($all_rows);
        $pagination_data['page_num_segment']          = 3;
        $pagination_data['limit']                     = $this->_get_limit();
        $pagination_data['pagination_root']           = 'admin_projects/manage';
        $pagination_data['record_name_plural']        = 'projects';
        $pagination_data['include_showing_statement'] = true;
        $data['pagination_data']                      = $pagination_data;

        $data['rows']              = $this->_reduce_rows($all_rows);
        $data['selected_per_page'] = $this->_get_selected_per_page();
        $data['per_page_options']  = $this->per_page_options;
        $data['view_module']       = 'admin_projects';
        $data['view_file']         = 'manage';
        $this->template('admin', $data);
    }


    /**
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    function show(): void
    {
        $this->module('trongate_security');
        $token     = $this->trongate_security->_make_sure_allowed();
        $update_id = (int) segment(3);

        if ($update_id == 0) {
            redirect('admin_projects/manage');
        }

        $data          = $this->_get_data_from_db($update_id);
        $data['token'] = $token;

        if ($data == false) {
            redirect('admin_projects/manage');
        } else {
            $data['update_id'] = $update_id;
            $data['headline']  = 'Project Information';
            $data['view_file'] = 'show';
            $this->template('admin', $data);
        }
    }


    /**
     * @param $all_rows
     *
     * @return array
     */
    function _reduce_rows($all_rows): array
    {
        $rows        = [];
        $start_index = $this->_get_offset();
        $limit       = $this->_get_limit();
        $end_index   = $start_index + $limit;

        $count = -1;
        foreach ($all_rows as $row) {
            $count++;
            if (($count >= $start_index) && ($count < $end_index)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * @return void
     * @throws ReflectionException
     */
    function submit(): void
    {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $submit = post('submit', true);

        if ($submit == 'Submit') {

            //PLEASE NOTE: max_size is in kilobytes
            $validation_str = 'allowed_types[gif,jpg,jpeg,png,zip]|max_size[2000]';

            if ($_FILES['cover_image']['name'] !== '') {
                $this->validation_helper->set_rules('cover_image', 'Cover Image', $validation_str);
            }

            $this->validation_helper->set_rules('title', 'Title', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('language', 'Language', 'required');
            $this->validation_helper->set_rules('content', 'Content', 'required|min_length[2]|max_length[2000]');
            $this->validation_helper->set_rules('client', 'Client', 'required|min_length[2]|max_length[255]');
            $this->validation_helper->set_rules('links', 'Links', 'required|min_length[2]|max_length[2000]');
            $this->validation_helper->set_rules('order', 'Order', 'required|integer');
            $this->validation_helper->set_rules('created_at', 'Created At', 'valid_datetimepicker_us');


            $result = $this->validation_helper->run();

            if ($result == true) {

                $update_id = (int) segment(3);
                $data      = $this->_get_data_from_post();

                if ($_FILES['cover_image']['name'] !== '') {
                    //upload the file
                    $config['destination']      = '../public/files/projects';
                    $config['make_rand_name']   = false;
                    $config['upload_to_module'] = false;

                    $file_info           = $this->upload_file($config);
                    $data['cover_image'] = 'files/projects/'.$file_info['file_name'];
                }

                // sanitize here!
                $data['content'] = $this->purifier->purify($data['content']);
                $data['links']   = $this->purifier->purify($data['links']);

                $data['created_at'] = str_replace(' at ', '', $data['created_at']);
                $data['created_at'] = date('Y-m-d H:i', strtotime($data['created_at']));

                // auto-update with the current datetime
                $data['updated_at'] = date('Y-m-d H:i', strtotime('now'));

                if ($update_id > 0) {

                    if ($_FILES['cover_image']['name'] !== '') {
                        $entity = $this->_get_data_from_db($update_id, 'projects');

                        // Delete previous file
                        $previous_files = array_filter(glob(dirname(__DIR__, 3).'/public/'.$entity['cover_image']));
                        foreach ($previous_files as $file) {
                            unlink($file);
                        }
                    }

                    //update an existing record
                    $this->model->update($update_id, $data, 'projects');
                    $flash_msg = 'The record was successfully updated';
                } else {
                    //insert the new record
                    $update_id = $this->model->insert($data, 'projects');
                    $flash_msg = 'The record was successfully created';
                }

                set_flashdata($flash_msg);
                redirect('admin_projects/show/'.$update_id);

            } else {
                //form submission error
                $this->create();
            }
        }

    }


    /**
     * @return void
     * @throws ReflectionException
     */
    function submit_delete(): void
    {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        $submit              = post('submit');
        $params['update_id'] = (int) segment(3);

        if (($submit == 'Yes - Delete Now') && ($params['update_id'] > 0)) {
            //delete all of the comments associated with this record
            $sql              = 'delete from trongate_comments where target_table = :module and update_id = :update_id';
            $params['module'] = 'projects';
            $this->model->query_bind($sql, $params);

            //delete the record
            $this->model->delete($params['update_id'], 'projects');

            //set the flashdata
            $flash_msg = 'The record was successfully deleted';
            set_flashdata($flash_msg);

            //redirect to the manage page
            redirect('admin_projects/manage');
        }
    }


    /**
     * @return int
     */
    function _get_limit(): int
    {
        if (isset($_SESSION['selected_per_page'])) {
            $limit = $this->per_page_options[$_SESSION['selected_per_page']];
        } else {
            $limit = $this->default_limit;
        }

        return $limit;
    }


    /**
     * @return float|int
     */
    function _get_offset(): float|int
    {
        $page_num = (int) segment(3);

        if ($page_num > 1) {
            $offset = ($page_num - 1) * $this->_get_limit();
        } else {
            $offset = 0;
        }

        return $offset;
    }


    /**
     * @return int|mixed
     */
    function _get_selected_per_page(): mixed
    {
        return (isset($_SESSION['selected_per_page'])) ? $_SESSION['selected_per_page'] : 1;
    }


    /**
     * @param $selected_index
     *
     * @return void
     * @throws ReflectionException
     */
    function set_per_page($selected_index): void
    {
        $this->module('trongate_security');
        $this->trongate_security->_make_sure_allowed();

        if ( ! is_numeric($selected_index)) {
            $selected_index = $this->per_page_options[1];
        }

        $_SESSION['selected_per_page'] = $selected_index;
        redirect('admin_projects/manage');
    }


    /**
     * @param $update_id
     *
     * @return array|void
     * @throws Exception
     */
    function _get_data_from_db($update_id)
    {
        $record_obj = $this->model->get_where($update_id, 'projects');

        if ($record_obj == false) {
            $this->template('error_404');
            die();
        } else {
            $data = (array) $record_obj;
            // sanitize here!
            $data['content'] = $this->purifier->purify($data['content']);

            return $data;
        }
    }


    /**
     * @return array
     */
    function _get_data_from_post(): array
    {
        $data['title']    = post('title', true);
        $data['language'] = post('language', true);
        $data['client']   = post('client', true);
        $data['order']    = post('order', true);

        // purifier should sanitize this field! clean_up is null by default
        $data['content'] = post('content');
        $data['links']   = post('links');

        $data['created_at'] = post('created_at', true);

        return $data;
    }

}
