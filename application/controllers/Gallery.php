<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends MY_Controller
{
	private $gallery_path = './uploads/gallery/';
	private $gellary_upload_error = array();

	function __construct()
	{
		parent::__construct();
		$this->load->model(array(
				'Property_model', 
				'Client_model', 
				'Contacts_model', 
				'Service_model', 
				'Property_services_model', 
				'Property_keys_model', 
				'Key_type_model',
				'Gallery_model',
				'Property_bins_model',
				'Council_model',
				'Gallery_images_model'
			));
		$this->set_data('active_menu', 'property');
		$this->set_data('class_name', strtolower(get_class($this)));
		$this->context = 'property';
	}

	function index($context, $context_id)
	{
    	$this->set_data('context_id', $context_id);
    	$this->set_data('context', $context);
    	$sql = "SELECT g.id AS id, 
					g.name, 
					gt.type AS type, 
					g.description, 
					g.context_id AS context_id, 
					g.active 
    			FROM gallery AS g
    			JOIN gallery_type AS gt ON g.gallery_type = gt.id 
    			WHERE g.context_id = $context_id AND g.context = '$context' AND g.active = ";
    	$this->set_data( 'records', $this->db->query( $sql."1" )->result() );
    	$this->set_data( 'inactive_records', $this->db->query( $sql."0" )->result() );
		$this->load->view('gallery/lists_gallery', $this->get_data());
	}

	function save($context_id, $context, $gallery_id=0)
	{
		$this->context = $context;

		$this->set_data('context_id', $context_id);
		$this->set_data('context', $context);
		$this->context = $context;
		$this->load->library('form_validation');

		$record = new Gallery_model();

		if ($gallery_id) { $record->load($gallery_id); }

		$this->set_data('record', $record);
    	$this->load->model('Gallery_type_model');
    	$this->set_data('gallery_types', $this->Gallery_type_model->get_dropdown_lists(1));
		if (isset($_POST['submit'])) {
       		$this->form_validation->set_rules('data[name]','Gallery name','required');
       		$this->form_validation->set_rules('data[gallery_type]','Category','required');
			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $key => $value) {
					$record->{$key} = $value;
				}
				$record->context_id = $context_id;
				$record->context = $this->context;
				$record->active = $record->id? $record->active: 1;
				$record->{$gallery_id?'updated_by':'added_by'} = $this->session->userdata('user_id');

				$file_datas = $this->multiple_upload();

				if ($this->is_uploaded($file_datas)) {
					if ($gal_id = $record->save()) {
						$this->insert_images($file_datas, $gal_id);
						$this->add_history($context_id, $gallery_id? "Gallery Updated":"Gallery Added");
						set_flash_message(0, $gallery_id? "Gallery Updated Successfully":"Gallery Added Successfully");
						redirect( site_url( "gallery/index/$context/$context_id" ) );
					}
				}else{
					$this->delete_images($file_datas);
					set_flash_message(2, '<p>'. join('</p><p>', $this->gellary_upload_error) .'</p>' );
				}
			}
		}
    	$this->load->view('gallery/form', $this->get_data());
	}

	function edit($gallery_id)
	{
		$this->load->library('form_validation');

		$record = new Gallery_model();
		$record->load($gallery_id);
		$this->context = $record->context;
		$this->set_data('context', $record->context);
		$this->set_data('context_id', $record->context_id);
		$this->set_data('record', $record);
    	$this->load->model('Gallery_type_model');
    	$this->set_data('gallery_types', $this->Gallery_type_model->get_dropdown_lists(1));

		if (isset($_POST['submit'])) {
       		$this->form_validation->set_rules('data[name]','Gallery name','required');
       		$this->form_validation->set_rules('data[gallery_type]','Category','required');
			if ( $this->form_validation->run() == TRUE ) {
				foreach ($this->input->post('data') as $key => $value) {
					$record->{$key} = $value;
				}
				$record->updated_by = $this->session->userdata('user_id');
				if ($gal_id = $record->save()) {
					$this->add_history($record->context_id, "Gallery Updated");
					set_flash_message(0, "Gallery Updated Successfully");
					redirect( site_url( "gallery/index/$record->context/$record->context_id" ) );
				}else{
					set_flash_message(1, "No Changes Made!");
					redirect( site_url( "gallery/index/$record->context/$record->context_id" ) );
				}
			}
		}
    	$this->load->view('gallery/form', $this->get_data());
	}

	function append_gallery($gallery_id)
	{
		$this->load->library('form_validation');

		$record = new Gallery_model();
		$record->load($gallery_id);
    	$this->set_data('record', $record);
		$this->context = $record->context;
		$this->set_data('context', $record->context);
		$this->set_data('context_id', $record->context_id);
    	$images = $this->Gallery_images_model->getWhere(array('gallery_id'=>$gallery_id));
		$this->set_data('images', $images);

		$images = $this->Gallery_images_model->getWhere(array('gallery_id'=>$gallery_id));
		$this->set_data('images', $images);

		if (isset($_POST['submit'])) {
       		$file_datas = $this->multiple_upload();

			if ($this->is_uploaded($file_datas)) {
				$this->insert_images($file_datas, $record->id);
				$this->add_history($record->context_id, "Gallery images added");
				set_flash_message(0, $gallery_id? "Gallery Updated Successfully":"Gallery Added Successfully");
				redirect( site_url( "gallery/index/$record->context/$record->context_id" ) );
			}else{
				$this->delete_images($file_datas);
				set_flash_message(2, '<p>'. join('</p><p>', $this->gellary_upload_error) .'</p>' );
			}
		}
		$this->load->view('gallery/append_form', $this->get_data());
	}

	function gallery_description($gallery_id)
	{
		$this->load->library('form_validation');

		$record = new Gallery_model();
		$record->load($gallery_id);
    	$this->set_data('record', $record);
		$this->set_data('context', $record->context);
		$this->set_data('context_id', $record->context_id);

		$images = $this->Gallery_images_model->getWhere(array('gallery_id'=>$gallery_id));
		$this->set_data('images', $images);
    	$this->set_data('context_id', $record->context_id);

		if (isset($_POST['submit'])) {
			foreach ($this->input->post('data') as $id => $data) {
				$image = new Gallery_images_model();
				$image->load($id);
				$image->title = $data['title'];
				$image->description = $data['description'];
				$image->save();
			}
			$this->add_history($record->context_id, "Gallery Images Title Updated");
			set_flash_message(0, "Gallery Images\' Description Updated Successfully");
			redirect( site_url( "gallery/index/$record->context/$record->context_id" ) );
		}
		$this->load->view('gallery/description_form', $this->get_data());
	}

	function gallery_slider($gallery_id)
	{
		$gallery = new Gallery_model();
		$gallery->load($gallery_id);
		$this->set_data('record', $gallery);
		$images = $this->Gallery_images_model->getWhere(array('gallery_id'=>$gallery_id));
		$this->set_data('images', $images);
		$this->load->view('properties/gallery_view', $this->get_data());
	}

    function delete_gallery($gallery_id)
    {
    	$gallery = new Gallery_model();
    	$gallery->load($gallery_id);
    	
    	$context_id = $gallery->context_id;
    	$context = $gallery->context;

    	$images = $this->Gallery_images_model->getWhere(array('gallery_id'=>$gallery_id));

    	foreach ($images as $image) {
    		$path = $this->gallery_path.$image->image;
    		// x($path);
			if ( file_exists($path) ) {
				unlink($path);
			}
			$image->delete();
    	}

    	$gallery->delete();

		$this->add_history($context_id, "Gallery Deleted");
		set_flash_message(0, "Gallery Deleted Successfully");
		redirect( site_url( "gallery/index/$context/$context_id" ) );
    }

	function is_uploaded($data)
	{
		$uploaded = true;
		foreach ($data as $file) {
			if (!$file) {
				$uploaded = false;
				break;
			}
		}
		return $uploaded;
	}

	function insert_images($data, $gallery_id)
	{
		$this->load->model('Gallery_images_model');
		foreach ($data as $file) {
			$record = new Gallery_images_model();
			$record->gallery_id = $gallery_id;
			$record->image = $file;
			$record->save();
		}
	}

	function delete_gallery_image()
	{
		if (isset($_POST)) {
			$image = new Gallery_images_model();
			$image->load($_POST['image_id']);
			$path = $this->gallery_path.$image->image;
			if (file_exists($path)) {
				unlink($path);
			}
			if($image->delete()){
				echo json_encode(array('status'=>true));
			}
		}
	}

	function delete_images($data)
	{
		foreach ($data as $file) {
			$path = $this->gallery_path.$file;
			if (file_exists($path) && $file) {
				unlink($path);
			}
		}
	}
    
    public function multiple_upload()
	{
	    $this->load->library('upload');
	    $number_of_files_uploaded = count($_FILES['upl_files']['name']);
	    $files = array();
	    // Faking upload calls to $_FILE
	    for ($i = 0; $i < $number_of_files_uploaded; $i++) :
	      	$_FILES['userfile']['name']     = $_FILES['upl_files']['name'][$i];
	      	$_FILES['userfile']['type']     = $_FILES['upl_files']['type'][$i];
	      	$_FILES['userfile']['tmp_name'] = $_FILES['upl_files']['tmp_name'][$i];
	      	$_FILES['userfile']['error']    = $_FILES['upl_files']['error'][$i];
	      	$_FILES['userfile']['size']     = $_FILES['upl_files']['size'][$i];
	      	$config = array(
		        // 'file_name'     => '',
		        'allowed_types' => 'jpg|jpeg|png|gif',
		        // 'max_size'      => 3000,
		        'overwrite'     => FALSE,
		        'upload_path' => $this->gallery_path
	      	);
	      	$this->upload->initialize($config);
	      	if ( ! $this->upload->do_upload() ) :
	      		$files[] = false;
		        $error = array('error' => $this->upload->display_errors());
	      		$this->gellary_upload_error[] = $error['error'];
	    	  else :
	        	$data = $this->upload->data();
	      		$files[] = $data['file_name'];
	      	endif;
	    endfor;
	    return $files;
	}

}









// Google Places APIs KEY
// AIzaSyBa0XPDzdP8ATw5PZPiv7Fm7DKm5gW_ko8