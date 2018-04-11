<?php

/**
 * USER MODAL
 */
class User_model extends MY_Model
{
    const DB_TABLE = 'users';
    const DB_TABLE_PK = 'id';

    public $id;
    public $user_name;
    public $password;
    public $user_title;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $cell;
    public $dob;
    public $user_role;

    public $address;
    public $address_state;
    public $address_long_state;
    public $address_suburb;
    public $address_post_code;
    public $address_location;

    public $remarks;
    public $active = 1;
    public $abn_no;
    public $acn_no;
    public $tfn_no; // tfn = ftn

    public $australian_citizen;
    public $permanent_resident;
    public $working_visa;
    public $expiry_date;
    public $hour_per_week;
    public $system_color;
    public $base_rate;

    public $account_number;
    public $bsb_no;
    public $bank_name;

    public $kin_name;
    public $kin_phone = '';
    public $kin_relationship;
    public $kin_address;
    public $kin_address_state;
    public $kin_address_long_state;
    public $kin_address_suburb;
    public $kin_address_post_code;
    public $kin_address_location;

    public $image;
    public $added_by;
//    public $added_time;
    public $updated_by;
//    public $updated_time;

    public static $permissions;

    public function authenticate($user_name,$password)
    {
        $this->db->where("active = 1 AND (user_name = '$user_name' OR email = '$user_name')");

        $this->db->limit(1);

        $query = $this->db->get(SELF::DB_TABLE);

        $user = $query->row();

        if ( $user && password_verify($password,$user->password) )
            return $user;
        
        return FALSE;
    }

    function get_dropdown_lists($first_empty=1, $active=1)
    {
        $ret = array_map(

                function($o){ 
                    return $o->first_name . ' ' . $o->last_name; 
                },

                $this->getWhere(array('active'=>1))
            );

        return $first_empty? array(''=>'') + $ret : $ret;
    }

    function get_birthday_users()
    {
        $sql = "
            SELECT * FROM `users`
                WHERE MONTHNAME(dob) = MONTHNAME(now())
        ";
        return $this->db->query($sql)->result();
    }

    public function getUsersByActiveStatus($is_active = true)
    {
        $sql = "
                SELECT GROUP_CONCAT(r.name SEPARATOR ' | ') AS role, u.* FROM users AS u 
                LEFT JOIN `role_user` AS ru ON ru.user_id = u.id
                LEFT JOIN `roles` AS r ON r.id = ru.role_id
                WHERE u.active = ?
                GROUP BY u.id";

        return $this->db->query($sql, [$is_active])->result();
    }

    public function assignRoles($roles)
    {
        $this->db->query("DELETE FROM role_user WHERE user_id = ?", [$this->id]);

        $data = [];

        foreach ($roles as $role_id) {
            array_push($data, [
                'role_id' => $role_id,
                'user_id' => $this->id
            ]);
        }

        return $this->db->insert_batch('role_user', $data);
    }

    public function getAllowedPermissions()
    {
        $sql = "SELECT r.name AS role, p.* FROM permissions AS p
                JOIN permission_role AS pr ON pr.permission_id = p.id
                JOIN roles AS r ON r.id = pr.role_id
                JOIN role_user AS ru ON ru.role_id = r.id
                JOIN users AS u ON u.id = ru.user_id
                WHERE u.id = ?";

        $query = $this->db->query($sql, [$this->id]);

        return array_unique(array_column($query->result_array(), 'name'));

    }

}

?>