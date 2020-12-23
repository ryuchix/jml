<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Api extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model(array('User_model'));

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    function login_post(){
        
        $username = $this->post('username');
        $password = $this->post('password');

        $found = $this->User_model->authenticate($username, $password);

        if ($found) {

            $this->response($found, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code

        }else{
            // Set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid Username/Password'
            ], REST_Controller::HTTP_UNAUTHORIZED); // NOT_FOUND (404) being the HTTP response code
        }

    } // end login function

    public function dashboard_get()
    {
        $this->load->model(array( 
            'Client_model', 
            'Supplier_model', 
            'Property_model', 
            'Complain_model',
            'Quote_model',
            'Equipment_model',
            'User_model',
            'Vehicle_model',
        ));
        $data = array();
        $data['countAllClient'] = $this->Client_model->get_count(0);
        $data['countAllProspect'] = $this->Client_model->get_count(1);
        $data['countAllSupplier'] = $this->Supplier_model->get_count();
        $data['countAllProperty'] = $this->Property_model->get_count();
        $data['countAllEquipment'] = $this->Equipment_model->get_count();
        $data['countAssignedComplaints'] = $this->Complain_model->count_open_or_assigned();
        $data['countTotalComplaints'] = $this->Complain_model->count();
        $data['countPendingQuotes'] = $this->Quote_model->count_where(['status'=>STATUS_PENDING]);
        $data['countAllVehicle'] = $this->Vehicle_model->count();
        
        $this->response($data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    public function users_get()
    {
        // Users from a data store e.g. database
        $users = [
            ['id' => 1, 'name' => 'John', 'email' => 'john@example.com', 'fact' => 'Loves coding'],
            ['id' => 2, 'name' => 'Jim', 'email' => 'jim@example.com', 'fact' => 'Developed on CodeIgniter'],
            ['id' => 3, 'name' => 'Jane', 'email' => 'jane@example.com', 'fact' => 'Lives in the USA', ['hobbies' => ['guitar', 'cycling']]],
        ];

        $id = $this->get('id');

        // If the id parameter doesn't exist return all the users

        if ($id === NULL)
        {
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($users)
            {
                // Set the response and exit
                $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
            else
            {
                // Set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }

        // Find and return a single record for a particular user.

        $id = (int) $id;

        // Validate the id.
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $user = NULL;

        if (!empty($users))
        {
            foreach ($users as $key => $value)
            {
                if (isset($value['id']) && $value['id'] === $id)
                {
                    $user = $value;
                }
            }
        }

        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    public function users_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function reset_password_put()
    {
        // $this->some_model->update_user( ... );
        // $message = [
        //     'id' => 100, // Automatically generated by the model
        //     'name' => $this->post('name'),
        //     'email' => $this->post('email'),
        //     'message' => 'Added a resource'
        // ];

        $this->db->where('email', $this->put('email'));
        $this->db->or_where('user_name', $this->put('email'));
        $this->db->limit(1);
        $user = $this->db->get(User_model::DB_TABLE)->row();

        if ($user) {
            $pass = new User_model();
            $pass->load($user->id);
            $pass->password = password_hash($this->put('new_password'), PASSWORD_BCRYPT, array('cost'=>12));
            if ($pass->save()) {
                $this->set_response($user, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
            }else{
                $this->set_response($user, REST_Controller::HTTP_NOT_FOUND); // PAGE NOT FOUND (404) being the HTTP response code
            }
        }else{
            $this->set_response(x($this->put()), REST_Controller::HTTP_OK); // UNAUTHORIZED (401) being the HTTP response code
        }
    }

    public function users_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}


// .viewing-page-1 #cssmenu ul ul {
//     bottom: 100%;
//     top: auto;
// }

// jQuery('.down-arrow').on('click', function(e){
//     e.preventDefault();
//     jQuery('a[href=#2]').trigger('click');
// });