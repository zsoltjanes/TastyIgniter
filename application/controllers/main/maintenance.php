<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function __construct() {
		parent::__construct(); 																	//  calls the constructor
		$this->load->library('user'); 														// load the user library
	}

	public function index() {
			
		if ($this->session->flashdata('alert')) {
			$data['alert'] = $this->session->flashdata('alert');  // retrieve session flashdata variable if available
		} else {
			$data['alert'] = '';
		}

		if (!empty($this->config->item('maintenance_mode')) AND ($this->config->item('maintenance_mode') === '1') AND !$this->user->isLogged()) {  													// if customer is not logged in redirect to account login page
			$maintenance_page = ($this->config->item('maintenance_page')) ? $this->config->item('maintenance_page') : '';

			$this->load->model('Pages_model');
			$page = $this->Pages_model->getPage($maintenance_page);      
			
			$data['title'] 			= $page['title'];
			$data['text_heading'] 	= $page['heading'];
			$data['content'] 		= $page['content'];
			
			$regions = array('header', 'content_top', 'content_left', 'content_right', 'footer');
			if (file_exists(APPPATH .'views/themes/main/'.$this->config->item('main_theme').'maintenance.php')) {
				$this->template->render('themes/main/'.$this->config->item('main_theme'), 'maintenance', $regions, $data);
			} else {
				$this->template->render('themes/main/default/', 'maintenance', $regions, $data);
			}
		} else {
			redirect('main/menus');
		}
	}
}

/* End of file maintenance.php */
/* Location: ./application/controllers/main/maintenance.php */