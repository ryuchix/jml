<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(['Role_model','Permission_model', 'Permission_role_model', 'Role_user_model']);
        $this->set_data('active_menu', 'users');
    }

    /* Role Default Method for the controller */
    function index()
    {
        $this->redirectIfNotAllowed('view-vehicle-service');
        
        $this->set_data( 'sub_menu', 'view_roles');

        $this->set_data( 'records', $this->Role_model->get() );

        $this->load->view('user/roles/lists', $this->get_data());

    }

    /* Insert New Role or Modifying Role */

    function save($id=0)
    {
        $this->redirectIfNotAllowed($id?'edit-role':'add-role');
        
        $role = new Role_model();

        if ($id) { $role->load($id); }
        
        $this->set_data('sub_menu', 'add_user');

        $this->set_data('permissions', $this->get_permissions());

        $this->set_data('selected_permissions', $this->getSelectedPermissions($id));

        $this->set_data('record', $role);

    	$this->load->library('form_validation');

    	if( !isset($_POST['submit']) )
        {
            
            $this->load->view( "user/roles/form", $this->get_data() );

            return;
        }

        $this->validate_fields($id);

        if( $this->form_validation->run() === FALSE )
        {
            $this->load->view("user/roles/form", $this->get_data() );

            return;
        }

        $this->db->trans_start();

        $role->name = $this->input->post('name');

        $role->description = $this->input->post('description');

        $role->{$id? 'updated_by':'created_by'} = $this->session->userdata('user_id');

        $i_r_e = $role->save(); // insert_id or effected row

        $id = $id? $id : $i_r_e;

        $role->attach_permissions($this->input->post('permissions'));

        $this->db->trans_complete();

        set_flash_message(0, 'Record saved Successfully.');

        redirect(site_url('roles/'));

    } // end add method

    protected function get_permissions()
    {
        $this->db->order_by('name');

        $permissions = $this->Permission_model->get(0, 0, 0);

        $grouped_permissions = [];

        foreach ($permissions as $perm) {
            
            $display_group = $perm->display_group; 
        
            unset($perm->display_group);

            $grouped_permissions[$display_group][] = $perm;
        }
        
        ksort($grouped_permissions);

        return $grouped_permissions;
    }

    protected function getSelectedPermissions($id)
    {
        if ( ! $id )
        {
            return [];
        }
        
        $permissions = $this->Permission_role_model->getWhere(['role_id'=>$id], false, "*", false);

        return array_map(function($permission){
            return $permission->permission_id;
        }, $permissions);

        // return array_column($permissions, 'permission_id');
    }

    public function show_permissions($id)
    {
        $data['permissions'] = $this->db->query("SELECT p.name, p.label FROM permissions p JOIN permission_role pr ON p.id = pr.permission_id AND pr.role_id = ?", [$id])
            ->result();

        $this->load->view('user/roles/permissions_show', $data);
    }


    /* Validate fields */
    function validate_fields($id)
    {
        $this->form_validation->set_rules('name','Role Name','required|is_unique[roles.name]');
        
        $this->form_validation->set_rules('permissions[]','Permssion','required', array('required' => 'You must select at least one perission in order to register new Role'));

        if($id)
            $this->form_validation->set_rules('name','Role Name','required|callback_custom_role_name_check['.$id.']');

    } // edit validate_fields


    /* Checking User Username is already exist or not while updated user information */
    public function custom_role_name_check($name,$id)
    {
        $this->db->where('name',$name);

        $this->db->where('id !=',$id);

        $role = $this->db->get('roles');

        if($role->row())
        {
            $this->form_validation->set_message('custom_role_name_check', 'The {field} must be unique. This is already in use.');

            return false;
        }

        else

        {
            return true;
        }
    }

} // end user class