<?php


$config = array(

    'login' => array(

        array(
            'field' => 'username',
            'label' => 'Username/Email',
            'rules' => 'required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required'
        ),

    ),

    'registration' => array(

        array(
            'field' => 'data[first_name]',
            'label' => 'First Name',
            'rules' => 'required'
        ),
        array(
            'field' => 'data[last_name]',
            'label' => 'Last Name',
            'rules' => 'required'
        ),
        array(
            'field' => 'data[user_role]',
            'label' => 'User Role',
            'rules' => 'required'
        ),
        array(
            'field' => 'data[email]',
            'label' => 'Email',
            'rules' => 'required|valid_email|is_unique[users.email]'
        ),
        array(
            'field' => 'data[user_name]',
            'label' => 'Username',
            'rules' => 'required|is_unique[users.user_name]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[3]|max_length[15]'
        ),
        array(
            'field' => 'confirm_password',
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]'
        ),

    ),

    'profile' => array(

        array(
            'field' => 'data[first_name]',
            'label' => 'First Name',
            'rules' => 'required'
        ),
        array(
            'field' => 'data[last_name]',
            'label' => 'Last Name',
            'rules' => 'required'
        ),

    ),

    'add_service' => array(

        array(
            'field' => 'data[name]',
            'label' => 'Service Name',
            'rules' => 'required|is_unique[service.name]'
        ),

        array(
            'field' => 'data[rate]',
            'label' => 'Rate',
            'rules' => 'required|numeric'
        )

    ),

    'add_client_type' => array(

        array(
            'field' => 'data[type]',
            'label' => 'Client type name',
            'rules' => 'required|is_unique[client_type.type]'
        )

    ),

    'add_client_contact' => array(

        array(
            'field' => 'data[contact_name]',
            'label' => 'Contact name',
            'rules' => 'required|max_length[255]'
        ),
        array(
            'field' => 'data[surname]',
            'label' => 'Surname',
            'rules' => 'required'
        )
    ),

    'add_bin_type' => array(

        array(
            'field' => 'data[type]',
            'label' => 'Bin type',
            'rules' => 'required|is_unique[bin_type.type]|max_length[255]'
        ),
        array(
            'field' => 'data[size]',
            'label' => 'Bin Size',
            'rules' => 'required|numeric'
        ),
        array(
            'field' => 'data[color]',
            'label' => 'Color',
            'rules' => 'required|max_length[255]'
        )

    ),

    'add_document_type' => array(

        array(
            'field' => 'data[type]',
            'label' => 'Document type',
            'rules' => 'required|is_unique[document_type.type]|max_length[255]'
        ),

    ),

    'add_client_note' => array(

        array(
            'field' => 'data[document_type]',
            'label' => 'Document type',
            'rules' => 'required'
        ),

        array(
            'field' => 'data[notes]',
            'label' => 'Notes',
            'rules' => 'required'
        ),

        array(
            'field' => 'data[user_roles][]',
            'label' => 'User Roles',
            'rules' => 'required'
        ),

    ),

    'add_client_file' => array(

        array(
            'field' => 'data[document_type]',
            'label' => 'Document type',
            'rules' => 'required'
        ),

        array(
            'field' => 'data[filename]',
            'label' => 'Filename',
            'rules' => 'required'
        )

    ),

);


?>