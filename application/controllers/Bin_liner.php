<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bin_liner extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model([
				'Bin_liner_setting_model',
				'Bin_liner_model',
				'Property_model',
				'Bin_liner_detail_model',
				'User_model'
			]);
		$this->set_data('active_menu', 'bin_liner');
		$this->set_data('class_name', strtolower(get_class($this)));
	}


	function index($disable = false, $modified_item_id = 0)
	{

		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');

		$this->set_data('sub_menu', 'add_bin_liner_settings');
		
		$this->set_data( 'inactive_records', $this->Bin_liner_setting_model->getWhere(array('active'=>0)) );
		$this->set_data( 'records', $this->Bin_liner_setting_model->getWhere(array('active'=>1)) );
		$this->load->view('bin_liners/lists', $this->get_data());
	}


	function record_list($disable = false, $modified_item_id = 0)
	{
		$this->set_data('sub_menu', 'view_bin_liner');
		
		$this->set_data( 'records', $this->Bin_liner_model->get_list() );
		$this->load->view('bin_liners/record_lists', $this->get_data());
	}

	function save($id=false){
		$this->set_data('sub_menu', 'add_bin_liner_settings');
		$record = new Bin_liner_model();
		if ($id) {
			$record->load($id);
		}
		$this->set_data('record', $record);
		$this->load->library('form_validation');
		$this->set_data( 'properties', $this->Property_model->get_dropdown_lists() );
		$this->set_data( 'liner_qty', [] );
		$this->set_data( 'liner_total', [] );

		$liners = $this->Bin_liner_setting_model->getWhere(['active'=>1, 'price >'=>0]);
		$this->set_data( 'bin_liners', $liners );
		
		if ($id) {
			$values = $this->get_liner_values($record->id);
			$this->set_data( 'liner_qty', $values['qty'] );
			$this->set_data( 'liner_total', $values['total'] );
		}

		$this->set_data( 'users', $this->User_model->get_dropdown_lists() );

		if( isset($_POST['submit']) ){
       		$this->form_validation->set_rules('date','Date','required');
       		$this->form_validation->set_rules('data[property_id]','Property','required');
       		$this->form_validation->set_rules('data[staff]','Staff','required');

			if ( $this->form_validation->run() == TRUE ) {

				$record->date = db_date($this->input->post('date'));
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}

				$inserted_result = $record->save();
				if ( $inserted_id = $id? $id: $inserted_result ) {
					$this->Bin_liner_detail_model->deleteWhere(array('liner_id'=>$inserted_id));
					foreach ($this->input->post('items') as $id => $qty) {
						if ($qty) {
							$detail_item = new Bin_liner_detail_model();
							$detail_item->liner_id 	= $inserted_id;
							$detail_item->setting_id= $id;
							$detail_item->qty 	 	= $qty;
							$detail_item->price 	= $liners[$id]->price;
							$detail_item->total 	= $qty * $liners[$id]->price;
							$detail_item->save();
						}
					}
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'bin_liner/record_list' ) );
				}

			}
		}
		$this->load->view('bin_liners/record_form',$this->get_data());
	}

	function settings($id=false){
		$this->set_data('sub_menu', 'add_bin_liner_settings');
		$this->load->library('form_validation');

		$record = new Bin_liner_setting_model();
		if ($id) {
			$record->load($id);
		}
		$this->set_data('record', $record);

		if( isset($_POST['submit']) ){
       		$this->form_validation->set_rules('data[name]','Name','required');
       		$this->form_validation->set_rules('data[price]','Price','required|numeric');

			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $field => $value) {
					$record->{$field} 	= $value;
				}
				$record->active = $id? $record->active:1;
				if ($record->save()) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( 'bin_liner/' ) );
				}

			}
		}
		$this->load->view('bin_liners/form',$this->get_data());
	}

	function get_liner_values($liner_id)
	{
		$items = $this->Bin_liner_detail_model->getWhere(['liner_id'=>$liner_id]);
		$ret = array();
		$qty = array();
		$total = array();
		foreach ($items as $id => $liner) {
			$qty[$liner->setting_id] = $liner->qty;
			$total[$liner->setting_id] = $liner->total;
		}
		$ret['qty'] = $qty;
		$ret['total'] = $total;
		return $ret;
	}

	function activation($id, $boolean=false)
	{
		$record = new Bin_liner_setting_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Bin Liner status changed to active');
			redirect( site_url( 'bin_liner/index/0/'.$id ) );
		}else{
			set_flash_message(0, 'Document Type status changed to inactive');
			redirect( site_url( 'bin_liner/index/1/'.$id ) );
		}
	}

}