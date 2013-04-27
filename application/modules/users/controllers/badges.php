<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Badges extends CI_Controller {

	 function __construct()
	 {
	   parent::__construct();
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
		$this->load->config('account/account');
        $this->load->library(array('account/authentication', 'form_validation'));
		$this->load->model(array('account/account_model', 'account/account_details_model', 'teleworkwizard/tp_model','user_model'));
		$this->load->language(array('general', 'account/account_profile'));
	 }
	 
	 function index()
	 {
		if ( ! $this->authentication->is_signed_in()) 
		{
			redirect('account/sign_in/?continue='.urlencode(base_url().'dashboard'));
		}
		

		
		if ($this->authentication->is_signed_in())
		{
			$account = $this->account_model->get_by_id($this->session->userdata('account_id'));
			redirect('badges/'.$account->username);
		}
	 }	
	function lookup()
	{
		if ( ! $this->authentication->is_signed_in()) 
		{
			redirect('sign_in/?continue='.urlencode(base_url().'dashboard'));
		}

			if ($this->authentication->is_signed_in())
		{
			// get user_id using username in url start 		
			$username = $this->uri->segment(2);
			$user_id = $this->user_model->userid_lookup($username);
			$user_id = $user_id ['0']->id;
			// get user_id using username in url end 


			$data['account'] = $this->account_model->get_by_id($user_id);
			$data['telework_tracker'] = $this->tp_model->get_by_id($user_id);
			$data['account_details'] = $this->account_details_model->get_by_account_id($user_id);
			$this->load->view('badges', isset($data) ? $data : NULL);
		}
		else
		redirect('');

	} 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */