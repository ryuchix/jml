<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['User_model','User_file_model', 'Role_model', 'Role_user_model']);
        $this->set_data('active_menu', 'users');
    }

    /* User Default Method for the controller */
    function index($disable = false, $modified_item_id=0)
    {
        $this->set_data( 'active_list', ($disable)?'':'active');
        $this->set_data( 'modified_item_id', $modified_item_id);
        $this->set_data( 'inactive_list', !($disable)?'':'active');
        $this->set_data( 'sub_menu', 'view_user');
        $this->set_data( 'records', $this->User_model->getUsersByActiveStatus() );
        $this->set_data( 'inactive_records', $this->User_model->getUsersByActiveStatus( false ) );
        $this->load->view('user/lists', $this->get_data());
    }

    /* Logging in users to the system */
    function login()
    {
    	$this->load->library('form_validation');
    	if ( isset( $_POST['submit'] ) ) {
    		if( $this->form_validation->run('login') == TRUE ){
	    		$username = $this->input->post('username');
	    		$password = $this->input->post('password');
	    		$found = $this->User_model->authenticate($username, $password);
	    		if ($found) {

	    			$this->session->set_userdata('logged_in',true);
                    $this->session->set_userdata('user_id', $found->id);
                    $this->session->set_userdata('user_role', $found->user_role);
                    $this->session->set_userdata('fullname', $found->first_name . ' ' .$found->last_name);
                    $this->session->set_userdata('username', $found->user_name);
                    $this->session->set_userdata('dp', $found->image);
                    $this->session->set_userdata('email', $found->email);
                    if (isset($_GET['redirect'])&&$found->user_role==ADMIN_ROLE) {
                        redirect(site_url($_GET['redirect']));
                    }else{ 
                        redirect(site_url());
                    }
	    		}else{
	    			$this->set_data('flash_message', 'Username/Password Invalid!');
	    		}
    		} // if form validation passes
    	}
    	$this->load->view( 'user/login', $this->get_data() );
    } // end login function

    /* Logging out the user from the system */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(site_url('users/login'));
    } // end logout function

    /* Insert New User or Modifying users */
    function save($id=0, $profile = false)
    {
        if ($this->hasAccess('add-user')) 
        {
            set_flash_message(2, $this->notPermittedMessage);
            redirect(site_url());
        }

        $record = new User_model();

        if ($id) {
            $record->load($id);
        }else{
            $this->set_data('sub_menu', 'add_user');            
        }
        
        $this->set_data('profile', $profile);
        
        $this->set_data('record', $record);
        
        $this->set_data('given_roles', $this->getGivenRoles($id));

        $this->set_data('roles', $this->Role_model->get_dropdown_lists(false));

    	$this->load->library('form_validation');

    	if( !isset($_POST['submit']) )
        {
            $this->load->view('user/register', $this->get_data() );

            return;
        }
            
        $this->validate_fields($id);

        if( $this->form_validation->run() === false )
        {
            $this->load->view('user/register', $this->get_data() );

            return;
        }

        foreach ($this->input->post('data') as $key => $value) 
        {
            $record->{$key} = $value;
        }
    
        $record->expiry_date = $this->input->post('data[expiry_date]')? db_date($this->input->post('data[expiry_date]')):null;
    
        $record->dob = $this->input->post('data[dob]')? db_date($this->input->post('data[dob]')):null;

        if (!$id) 
        {
            $record->user_title   = '';
        
            $record->password     = password_hash($this->input->post('password'), PASSWORD_BCRYPT, array('cost'=>12));
        
            $record->added_by     = $this->session->userdata('user_id');
        }

        // x($this->input->post());

        // die();

        $this->db->trans_start();

        $inserted_id_or_effected_row = $record->save();

        $record->assignRoles($this->input->post('role_ids'));

        $this->db->trans_complete();

        $id = $id? $id: $inserted_id_or_effected_row;

        if ($profile) 
        {
            set_flash_message(0, 'Profile Saved');

            $this->session->set_userdata('fullname', $this->input->post('data[first_name]') . ' ' .$this->input->post('data[last_name]'));

            $this->session->set_userdata('username', $this->input->post('data[user_name]'));

            $this->session->set_userdata('email', $this->input->post('data[email]'));

            $this->session->set_userdata('dp', $this->input->post('data[image]'));

            redirect(site_url());
        }

        set_flash_message(0, 'Save Changes.');

        redirect(site_url("users/"));

        $this->load->view('user/register', $this->get_data() );

    } // end add method

    function getGivenRoles($id)
    {
        if ( ! $id ) {
            return [];
        }
        
        return array_column($this->Role_user_model->getWhere(['user_id'=>$id], false, "*", false), 'role_id');
    }


    /* User Profile to update his details */
    function profile()
    {
        $id = $this->session->userdata('user_id');
        
        $this->save($id, true);

    } // edit prfile


    /* Profile Updated by users itself */
    function validate_fields($id)
    {
        $this->form_validation->set_rules('data[first_name]','First Name','required');
        $this->form_validation->set_rules('data[last_name]','Last Name','required');
        $this->form_validation->set_rules('role_ids[]','User Role','required');
        
        $this->form_validation->set_rules('data[address]','Address','required');
        $this->form_validation->set_rules('data[address_state]','State','required');
        $this->form_validation->set_rules('data[address_suburb]','Suburb','required');
        $this->form_validation->set_rules('data[address_post_code]','Post Code','required');
        
        $this->form_validation->set_rules('data[kin_name]','Kin Bane','required');
        $this->form_validation->set_rules('data[kin_relationship]','Relationship','required');
        $this->form_validation->set_rules('data[kin_address]','Address','required');
        $this->form_validation->set_rules('data[kin_address_state]','State','required');
        $this->form_validation->set_rules('data[kin_address_suburb]','Suburb','required');
        $this->form_validation->set_rules('data[kin_address_post_code]','Post Code','required');

        $this->form_validation->set_rules('data[australian_citizen]','Citizen','required');
        $this->form_validation->set_rules('data[permanent_resident]','Permanent Resident','required');
        $this->form_validation->set_rules('data[hour_per_week]','Restriction hours per week','required');
        $this->form_validation->set_rules('data[system_color]','Color','required');
        $this->form_validation->set_rules('data[base_rate]','Base Rate','required|numeric');

        $this->form_validation->set_rules('data[bank_name]','Bank Name','required');
        $this->form_validation->set_rules('data[bsb_no]','BSB','required');
        $this->form_validation->set_rules('data[account_number]','Account No','required');
        $this->form_validation->set_rules('data[working_visa]','Working Visa','required');

        if ($this->input->post('data[working_visa]')=="Yes") {
            $this->form_validation->set_rules('data[expiry_date]','Expiry Date','required');
        }
        // if form is updating not inserting.
        if ($id) {
            $this->form_validation->set_rules('data[email]','Email','required|callback_custom_email_check['.$id.']');
            $this->form_validation->set_rules('data[user_name]', 'Username','required|callback_custom_username_check['.$id.']');
        }else{
            $this->form_validation->set_rules('password','Password','required|min_length[3]|max_length[15]');
            $this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[password]');
            $this->form_validation->set_rules('data[email]','Email','required|is_unique[users.email]');
            $this->form_validation->set_rules('data[user_name]', 'Username','required|is_unique[users.user_name]');
        } // else for update
    } // edit prfile

    /* Activation or deactivation */
    function activation($id, $boolean=false)
    {
        $record = new User_model();
        
        $record->load($id);
        
        $record->active = $boolean;
        
        $record->save();
        
        if ($boolean) 
        {
            set_flash_message(0, 'User status changed to active');
            redirect( site_url( 'users/index/0/'.$id ) );
        }

        set_flash_message(0, 'User status changed to inactive');
        
        redirect( site_url( "users/index/1/$id" ) );
    }

    /* Checking User Username is already exist or not while updated user information */
    public function custom_username_check($user_name,$id)
    {
        $this->db->where('user_name',$user_name);
        
        $this->db->where('id !=',$id);
        
        $users = $this->db->get('users');
        
        if($users->row())
        {
            $this->form_validation->set_message('custom_username_check', 'The {field} must be unique. This is already in use.');

            return false;
        }

        return true;
    }

    /* Checking User Email is already exist or not while updated user information */
    public function custom_email_check($email,$id)
    {
        $this->db->where('email',$email);

        $this->db->where('id !=',$id);

        $users = $this->db->get('users');

        if($users->row())
        {
            $this->form_validation->set_message('custom_email_check', 'The {field} must be unique. This is already in use.');
        
            return false;
        }
        
        return true;
    }

    function view($id)
    {
        $user = new User_model();
        $user->load($id);
        if (!$user) {
            $this->load->library('fpdf');
            $pdf = new FPDF("L");
            $pdf->AddPage();
            $pdf->SetFont("Arial", "", 26);
            $pdf->Cell(0, 40, "No record found!", 0, 1, "C");
            $pdf->Output();
        }
        else
        {
            $this->load->library('User_view');
            $pdf = new User_view($user, "L");
            $pdf->AddPage();
            $pdf->display_output();
        }
    }

    public function export()
    {
        $this->load->dbutil();

        $replace_columns = [
            "cell" => "mobile"
        ];

        $exclude = [
            "id",
            // "user_role",
            "address_location",
            "kin_address_location",
            // "image",
            "password",
            "user_title",
            "added_by",
            "added_time",
            "updated_by",
            "updated_time"
        ];

        $refl = new ReflectionClass('User_model');

        $columns = $this->db->query("SELECT * FROM " . $refl->getConstants()['DB_TABLE'] . ' LIMIT 1')->row_array();

        if (!$columns) {

            set_flash_message(2, "There is not result!");

            redirect( site_url() );

        }

        $columns = array_filter(array_keys($columns), function($key) use($exclude){

            return !in_array($key, $exclude);

        });

        foreach ($columns as $index => $column) {

            if(array_key_exists($column, $replace_columns))
            {
                $columns[$index] = $column . ' AS ' . $replace_columns[$column];
            }

        }

        $query = $this->db->query("SELECT ". join($columns, ', ') ." FROM " . $refl->getConstants()['DB_TABLE']);

        $data = $this->dbutil->csv_from_result($query);

        header('Content-Type: application/csv');
        
        header('Content-Disposition: attachment; filename="users.csv";');

        echo $data;

        exit();

    }

    /****************************************** User Files *******************************************/

    function files($client_id, $action='', $file_id=0)
    {
        switch ($action) {
            case 'save':
                $this->save_client_file($client_id, $file_id);
                break;
            
            default:
                $this->files_list($client_id);
                break;
        }
    }

    function save_client_file($user_id, $file_id=0)
    {
        $record = new User_file_model();
        if ($file_id) {
            $record->load($file_id);
        }
        $this->set_data('record', $record);

        $this->set_data('sub_menu', 'x');
        
        $this->set_data('user_id', $user_id);

        $this->set_data('document_types', $this->get_document_types());

        $this->load->library('form_validation');

        if( isset($_POST['submit']) ){
            
            if ( $this->form_validation->run('add_client_file') ) {

                $record->user_id    = $user_id;
                $record->filename  = $this->input->post('data')['filename'];
                $record->document_type  = $this->input->post('data')['document_type'];
                $record->description    = $this->input->post('data')['description'];
                $record->image          = $this->input->post('data')['image'];

                $record->active = $file_id ? $record->active : 1;

                $record->{$file_id? 'updated_by':'added_by'} = $this->session->userdata('user_id');

                if ($id = $record->save()) {
                    set_flash_message(0, "Record Submitted Successfully!");
                    redirect( site_url( "users/files/$user_id/" ) );
                }else{
                    set_flash_message(2, "No changes made.");
                }
            
            }

        }
        $this->load->view('user/file_form', $this->get_data());
    }

    function files_list($user_id)
    {
        $this->set_data('user_id', $user_id);
        $sql = "SELECT n.id AS id, d.type AS document_type, n.description, n.filename, n.image FROM user_file AS n 
                JOIN document_type AS d ON d.id = n.document_type WHERE n.user_id = $user_id";
        $this->set_data( 'records', $this->db->query( $sql )->result() );
        $this->load->view('user/lists_files', $this->get_data());
    }

    function get_document_types()
    {
        $this->load->model('Document_type_model');
        return array_map(
                    function($o){ 
                        return $o->type; 
                    }, 
                    $this->Document_type_model->getWhere(array('active'=>1))
                ); // array_map
    }

    function upload_client_file($id=0)
    {
        // upload_file( $folder, $file_types, $model )
        $this->upload_file('user_files', false, 'User_file_model', $id);
    }

    function upload_file($folder, $file_type=false, $model, $record_id)
    {
        $config['upload_path'] = './uploads/'.$folder;

        if ($file_type) {
            $config['allowed_types'] = $file_type;
        }else{
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $not_allowed_types = array('exe', 'bat', 'php', 'js', 'java', 'asp', 'aspx');
            if ( in_array($ext, $not_allowed_types) ) {
                $config['allowed_types'] = 'gif|jpg|png|tif|doc|docx|word|pdf';
            }else{
                $config['allowed_types'] = $ext;
            }
        }

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            $s = json_encode($error);
            echo $s;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            if ( isset($_POST['old_image']) && !empty($_POST['old_image'])) {
                $this->delete_uploaded_file($folder, $_POST['old_image']);
            }

            if ( $record_id ) {
                $record = new $model();
                $record->load($record_id);
                if ($record->image) {
                    $this->delete_uploaded_file($folder, $record->image);
                }
                $record->image = $data['upload_data']['file_name'];
                $record->save();
            }
            $s = json_encode($data['upload_data']);
            echo $s;
        }
    }

    function delete_via_ajax($folder, $model)
    {
        if (isset($_POST['rec']) && !empty($_POST['rec']) && $_POST['rec'] !== '') {
            $model = $model.'_model';
            $record = new $model();
            $record->load($_POST['rec']);
            $record->image = '';
            $record->save();
        }
        if (isset($_POST['file_name'])) {
            echo json_encode( array('status' => $this->delete_uploaded_file($folder, $_POST['file_name']) ) );
        }
    }

    function delete_uploaded_file($folder, $filename)
    {
        $file = './uploads/'.$folder.'/'.$filename;
        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }

    function delete_file($id)
    {
        $record = new User_file_model();
        $record->load($id);
        if ($this->delete_uploaded_file("user_files", $record->image)) {
            if($record->delete()){
                set_flash_message(0,"File Deleted Succress fully");
                redirect( site_url( "users/files/$record->user_id" ) );
            }

        }
    }


} // end user class