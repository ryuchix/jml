<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Property_video extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Property_model', 
				'Property_video_model',
		));
		$this->set_data('active_menu', 'property');
		$this->set_data('class_name', strtolower(get_class($this)));
	}

	function lists($property_id, $disable = false, $modified_item_id = 0)
	{
		$this->set_data( 'active_list', ($disable)?'':'active');
		$this->set_data( 'modified_item_id', $modified_item_id);
		$this->set_data( 'inactive_list', !($disable)?'':'active');
		$this->set_data('property_id', $property_id);
		
		$this->set_data( 'inactive_records', $this->Property_video_model->getWhere(['property_id'=>$property_id, 'active'=>0]) );
		$this->set_data( 'records', $this->Property_video_model->getWhere(['property_id'=>$property_id, 'active'=>1]) );
		$this->load->view('properties/lists_videos', $this->get_data());
	}

	function save($property_id, $id=false){

		$record = new Property_video_model();
		$this->set_data( 'property_id', $property_id );
		$vehicle = new Property_model();
		$vehicle->load($property_id);

		if ($id) { $record->load($id); }else{  $record->property_id = $property_id; }

		$this->set_data('record', $record);
		$this->load->library('form_validation');

		if( isset($_POST['submit']) ){
			
			$this->validate_form($id);
       		
			if ( $this->form_validation->run() == TRUE ) {
				
				foreach ($this->input->post('data') as $field => $value) { $record->{$field} = $value; }

				if ( $record->save() ) {
					set_flash_message(0, "Record Submitted Successfully!");
					redirect( site_url( $this->data['class_name']."/lists/$property_id" ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( $this->data['class_name']."/lists/$property_id" ) );
				}
			}
		}
		$this->load->view('properties/video_form',$this->get_data());
	}

	function validate_form($id)
	{
       	// $this->form_validation->set_rules('data[vehicle_id]','Vehicle','required');
       	$this->form_validation->set_rules('data[title]','Title','required');
       	$this->form_validation->set_rules('data[url]','Url','required');
	}

	function activation($id, $boolean=false)
	{
		$record = new Property_video_model();
		$record->load($id);
		$record->active = $boolean;
		$record->save();
		if ($boolean) {
			set_flash_message(0, 'Video status changed to active');
			redirect( site_url( "property_video/lists/$record->property_id/0/$id" ) );
		}else{
			set_flash_message(0, 'Video status changed to inactive');
			redirect( site_url( "property_video/lists/$record->property_id/1/$id" ) );
		}
	}

	function video($id)
	{
		$video = new Property_video_model();
		$video->load($id);
		echo sprintf('<iframe width="100%%" height="400" src="%s" frameborder="0" allowfullscreen></iframe>', str_replace(['youtube.com/','watch?v='], ['youtube.com/embed/',''], $video->url));
	}

}