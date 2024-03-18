<?php

class Entries extends Trongate {

    /**
     * To sanitize user input from TinyMCE text editor
     * Usage: $clean_html = $this->purifier->purify($dirty_html);
     *
     * @var HTMLPurifier
     */
    private HTMLPurifier $purifier;

	private $default_limit = 20;
	private $per_page_options = array( 10, 20, 50, 100 );


	public function __construct( $module_name = null ) {
		parent::__construct( $module_name );

        $this->purifier = new HTMLPurifier();
	}


	/**
	 * Show entries for the public
	 * @return void
	 * @throws Exception
	 */
	public function entry() {

		$id = segment( 3 );
        settype( $id, 'string' );

		$data['current_entry']          = $this->model->get_where_custom(
			'url_string',
			$id,
			'=',
			'id',
			'entries',
			1
		)[0];
		$data['current_entry']->content = $this->purifier->purify( $data['current_entry']->content );

		$data['entries'] = $this->model->get( 'id' );


		// SEO
		$data['title']       = $data['current_entry']->title;
		$data['description'] = str_split( strip_tags( $data['current_entry']->content ), 150 )[0] . '...';

		$data['view_module'] = 'entries';
		$data['view_file']   = 'public/entry';

		$this->template( 'clean_narrow', $data );
	}


	function update()
	{
		$data['title'] = 'Ez egy csodálatos nap volt!';

		$this->model->update(4, $data, 'entries');
	}


	function delete($update_id)
	{
		settype($update_id, 'int');
		$this->model->delete($update_id, 'entries');
		set_flashdata('The record was successfully deleted');
		redirect('entries/manage');

		/* $delete_id = segment(3);
		 settype($delete_id, 'int');
		 $this->model->delete($delete_id, 'entries');
		*/
	}


	function search()
	{
		$search_phrase      = segment(3);
		settype($search_phrase, 'string');

		$params['title']   = '%' . trim($search_phrase) . '%';
		$params['content'] = '%' . trim($search_phrase) . '%';
		$sql               = 'select * from entries
            WHERE title LIKE :title
			OR content LIKE :content
            ORDER BY id';
		$all_rows          = $this->model->query_bind( $sql, $params, 'object' );

		echo json_encode($all_rows, JSON_PRETTY_PRINT);
		die;
	}



	/**
	 * Show entries for the public
	 * @return void
	 * @throws Exception
	 */
	public function index() {

		$data['entries']     = $this->model->get( 'id' );
		$data['view_module'] = 'entries';
		$data['view_file']   = 'public/index';

		// SEO
		$data['title']       = 'Entries';
		$data['description'] = 'This is the blog page with the newest entries';

		$this->template( 'clean_narrow', $data );
	}


	function create() {
		$this->module( 'trongate_security' );
		$this->trongate_security->_make_sure_allowed();

		$update_id = (int) segment( 3 );
		$submit    = post( 'submit' );

		if ( ( $submit == '' ) && ( $update_id > 0 ) ) {
			$data = $this->_get_data_from_db( $update_id );
		} else {
			$data = $this->_get_data_from_post();
		}

		if ( $update_id > 0 ) {
			$data['headline']   = 'Update Entry Record';
			$data['cancel_url'] = BASE_URL . 'entries/show/' . $update_id;
		} else {
			$data['headline']   = 'Create New Entry Record';
			$data['cancel_url'] = BASE_URL . 'entries/manage';
		}

		$data['form_location'] = BASE_URL . 'entries/submit/' . $update_id;
		$data['view_file']     = 'create';
		$this->template( 'admin', $data );
	}

	function manage() {
		$this->module( 'trongate_security' );
		$this->trongate_security->_make_sure_allowed();

		if ( segment( 4 ) !== '' ) {
			$data['headline']  = 'Search Results';
			$searchphrase      = trim( $_GET['searchphrase'] );
			$params['title']   = '%' . $searchphrase . '%';
			$params['content'] = '%' . $searchphrase . '%';
			$sql               = 'select * from entries
            WHERE title LIKE :title
            OR content LIKE :content
            ORDER BY id';
			$all_rows          = $this->model->query_bind( $sql, $params, 'object' );
		} else {
			$data['headline'] = 'Manage Entries';
			$all_rows         = $this->model->get( 'id' );
		}

		$pagination_data['total_rows']                = count( $all_rows );
		$pagination_data['page_num_segment']          = 3;
		$pagination_data['limit']                     = $this->_get_limit();
		$pagination_data['pagination_root']           = 'entries/manage';
		$pagination_data['record_name_plural']        = 'entries';
		$pagination_data['include_showing_statement'] = true;
		$data['pagination_data']                      = $pagination_data;

		$data['rows']              = $this->_reduce_rows( $all_rows );
		$data['selected_per_page'] = $this->_get_selected_per_page();
		$data['per_page_options']  = $this->per_page_options;
		$data['view_module']       = 'entries';
		$data['view_file']         = 'manage';
		$this->template( 'admin', $data );
	}

	function show() {
		$this->module( 'trongate_security' );
		$token     = $this->trongate_security->_make_sure_allowed();
		$update_id = (int) segment( 3 );

		if ( $update_id == 0 ) {
			redirect( 'entries/manage' );
		}

		$data          = $this->_get_data_from_db( $update_id );
		$data['token'] = $token;

		if ( $data == false ) {
			redirect( 'entries/manage' );
		} else {
			$data['update_id'] = $update_id;
			$data['headline']  = 'Entry Information';
			$data['view_file'] = 'show';
			$this->template( 'admin', $data );
		}
	}

	function _reduce_rows( $all_rows ) {
		$rows        = [];
		$start_index = $this->_get_offset();
		$limit       = $this->_get_limit();
		$end_index   = $start_index + $limit;

		$count = - 1;
		foreach ( $all_rows as $row ) {
			$count ++;
			if ( ( $count >= $start_index ) && ( $count < $end_index ) ) {
				$rows[] = $row;
			}
		}

		return $rows;
	}

	function submit() {
		$this->module( 'trongate_security' );
		$this->trongate_security->_make_sure_allowed();

		$submit = post( 'submit', true );

		if ( $submit == 'Submit' ) {

			$this->validation_helper->set_rules( 'title', 'Title', 'required|min_length[2]|max_length[255]' );
			$this->validation_helper->set_rules( 'content', 'Content', 'required|min_length[2]' );
			$this->validation_helper->set_rules( 'created_at', 'Created At', 'required|valid_datetimepicker_us' );

			$result = $this->validation_helper->run();

			if ( $result == true ) {

				$update_id          = (int) segment( 3 );
				$data               = $this->_get_data_from_post();
				$data['url_string'] = strtolower( url_title( $data['title'] ) );

				// sanitize here!
				$data['content'] = $this->purifier->purify( $data['content'] );

				$data['created_at'] = str_replace( ' at ', '', $data['created_at'] );
				$data['created_at'] = date( 'Y-m-d H:i', strtotime( $data['created_at'] ) );


				if ( $update_id > 0 ) {
					//update an existing record
					$this->model->update( $update_id, $data, 'entries' );
					$flash_msg = 'The record was successfully updated';
				} else {
					//insert the new record
					$update_id = $this->model->insert( $data, 'entries' );
					$flash_msg = 'The record was successfully created';
				}

				set_flashdata( $flash_msg );
				redirect( 'entries/show/' . $update_id );

			} else {
				//form submission error
				$this->create();
			}

		}

	}

	function submit_delete() {
		$this->module( 'trongate_security' );
		$this->trongate_security->_make_sure_allowed();

		$submit              = post( 'submit' );
		$params['update_id'] = (int) segment( 3 );

		if ( ( $submit == 'Yes - Delete Now' ) && ( $params['update_id'] > 0 ) ) {
			//delete all of the comments associated with this record
			$sql              = 'delete from trongate_comments where target_table = :module and update_id = :update_id';
			$params['module'] = 'entries';
			$this->model->query_bind( $sql, $params );

			//delete the record
			$this->model->delete( $params['update_id'], 'entries' );

			//set the flashdata
			$flash_msg = 'The record was successfully deleted';
			set_flashdata( $flash_msg );

			//redirect to the manage page
			redirect( 'entries/manage' );
		}
	}

	function _get_limit() {
		if ( isset( $_SESSION['selected_per_page'] ) ) {
			$limit = $this->per_page_options[ $_SESSION['selected_per_page'] ];
		} else {
			$limit = $this->default_limit;
		}

		return $limit;
	}

	function _get_offset() {
		$page_num = (int) segment( 3 );

		if ( $page_num > 1 ) {
			$offset = ( $page_num - 1 ) * $this->_get_limit();
		} else {
			$offset = 0;
		}

		return $offset;
	}

	function _get_selected_per_page() {
		$selected_per_page = ( isset( $_SESSION['selected_per_page'] ) ) ? $_SESSION['selected_per_page'] : 1;

		return $selected_per_page;
	}

	function set_per_page( $selected_index ) {
		$this->module( 'trongate_security' );
		$this->trongate_security->_make_sure_allowed();

		if ( ! is_numeric( $selected_index ) ) {
			$selected_index = $this->per_page_options[1];
		}

		$_SESSION['selected_per_page'] = $selected_index;
		redirect( 'entries/manage' );
	}

	function _get_data_from_db( $update_id ) {
		$record_obj = $this->model->get_where( $update_id, 'entries' );

		if ( $record_obj == false ) {
			$this->template( 'error_404' );
			die();
		} else {
			$data = (array) $record_obj;

			return $data;
		}
	}

	function _get_data_from_post() {
		$data['title'] = post( 'title', true );

		// purifier should sanitize this field! clean_up is null by default
		$data['content']    = post( 'content' );
		$data['created_at'] = post( 'created_at', true );

		return $data;
	}

}
