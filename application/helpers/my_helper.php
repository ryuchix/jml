<?php

defined("ADMIN_ROLE")? null: define("ADMIN_ROLE", "1");
defined("STAFF_ROLE")? null: define("STAFF_ROLE", "2");
defined("OFFICE_MANAGER_ROLE")? null: define("OFFICE_MANAGER_ROLE", "3");
defined("OPERATION_MANAGER_ROLE")? null: define("OPERATION_MANAGER_ROLE", "4");

function get_user_role($role)
{
  $user_roles = array(
    ADMIN_ROLE=>'Admin',
    STAFF_ROLE=>'Staff / Contractor',
    OFFICE_MANAGER_ROLE=>'Office Manager',
    OPERATION_MANAGER_ROLE=>'Operation Manager',
    );
  return isset($user_roles[$role]) ? : '';
}

defined("STATUS_AWAITING_FOR_APPROVAL")? null: define("STATUS_AWAITING_FOR_APPROVAL", 0);
defined("STATUS_OPEN")? null: define("STATUS_OPEN", 1);
defined("STATUS_ASSIGNED")? null: define("STATUS_ASSIGNED", 2);
defined("STATUS_RESOLVED")? null: define("STATUS_RESOLVED", 3);
defined("STATUS_CLOSED")? null: define("STATUS_CLOSED", 4);
defined("STATUS_VOID")? null: define("STATUS_VOID", 5);
defined("STATUS_PENDING")? null: define("STATUS_PENDING", 6);
defined("STATUS_WON")? null: define("STATUS_WON", 7);
defined("STATUS_LOST")? null: define("STATUS_LOST", 8);
defined("STATUS_DUE")? null: define("STATUS_DUE", 9);
defined("STATUS_PAID")? null: define("STATUS_PAID", 10);
defined("STATUS_LOAN")? null: define("STATUS_LOAN", 11);
defined("STATUS_APPROVED")? null: define("STATUS_APPROVED", 12);
defined("STATUS_COLLECTED")? null: define("STATUS_COLLECTED", 13);
defined("STATUS_DELIVERED")? null: define("STATUS_DELIVERED", 14);

function get_status($status_index)
{
  $status = array(
      STATUS_AWAITING_FOR_APPROVAL => 'Awaiting for Approval',
      STATUS_OPEN     => 'Open',
      STATUS_ASSIGNED => 'Assigned',
      STATUS_RESOLVED => 'Resolved',
      STATUS_CLOSED   => 'Closed',
      STATUS_VOID     => 'Void',
      STATUS_PENDING  => 'Pending',
      STATUS_WON      => 'Won',
      STATUS_LOST     => 'Lost',
      STATUS_DUE      => 'Due',
      STATUS_PAID     => 'Paid',
      STATUS_LOAN     => 'Loan',
      STATUS_APPROVED     => 'Approved',
      STATUS_COLLECTED     => 'Collected',
      STATUS_DELIVERED     => 'Delivered',
  );
  return $status[$status_index];
}

defined("FREQUENCY_WEEKLY")? null: define("FREQUENCY_WEEKLY", 1);
defined("FREQUENCY_FORNIGHTLY")? null: define("FREQUENCY_FORNIGHTLY", 2);
defined("FREQUENCY_MONTHLY")? null: define("FREQUENCY_MONTHLY", 3);
defined("FREQUENCY_YEARLY")? null: define("FREQUENCY_YEARLY", 4);
defined("FREQUENCY_EIGHT_WEEKLY")? null: define("FREQUENCY_EIGHT_WEEKLY", 5);
defined("FREQUENCY_TWELVE_WEEKLY")? null: define("FREQUENCY_TWELVE_WEEKLY", 6);
defined("FREQUENCY_ONE_OFF")? null: define("FREQUENCY_ONE_OFF", 7);
defined("FREQUENCY_TWENTY_SIX_WEEKLY")? null: define("FREQUENCY_TWENTY_SIX_WEEKLY", 8);

function get_frequency($frequency_index=0)
{
  $frequency = array(
      FREQUENCY_ONE_OFF=> 'One Off',
      FREQUENCY_WEEKLY=> 'Weekly',
      FREQUENCY_FORNIGHTLY=> 'Fortnightly',
      FREQUENCY_MONTHLY=> 'Monthly',
      FREQUENCY_YEARLY=> 'Yearly',
      FREQUENCY_EIGHT_WEEKLY=> '8 Weekly',
      FREQUENCY_TWELVE_WEEKLY=> '12 Weekly',
      FREQUENCY_TWENTY_SIX_WEEKLY=> '26 Weekly'
  );
  return isset($frequency[$frequency_index])?$frequency[$frequency_index]:$frequency;
}

defined("FUEL")? null: define("FUEL", 1);
defined("DIESEL")? null: define("DIESEL", 2);

function get_fuel_types($fuel_type_index=0)
{
  $fuel_type = array(
      FUEL    => 'Fuel',
      DIESEL  => 'Diesel'
  );
  return isset($fuel_type[$fuel_type_index])?$fuel_type[$fuel_type_index]:$fuel_type;
}

defined("JOB_CATEGORY_GENERAL_TASK")?     null: define("JOB_CATEGORY_GENERAL_TASK", 1);
defined("JOB_CATEGORY_STRATA_CLEANING")?  null: define("JOB_CATEGORY_STRATA_CLEANING", 2);
defined("JOB_CATEGORY_BIN_CLEANING")?     null: define("JOB_CATEGORY_BIN_CLEANING", 3);
defined("JOB_CATEGORY_BIN_TO_CURB")?      null: define("JOB_CATEGORY_BIN_TO_CURB", 4);
defined("JOB_CATEGORY_METER_READING")?    null: define("JOB_CATEGORY_METER_READING", 5);
defined("JOB_CATEGORY_QUOTATION")?        null: define("JOB_CATEGORY_QUOTATION", 6);
defined("JOB_CATEGORY_SITE_INSPECTION")?  null: define("JOB_CATEGORY_SITE_INSPECTION", 7);
defined("JOB_CATEGORY_WINDOW_CLEANING")?  null: define("JOB_CATEGORY_WINDOW_CLEANING", 8);
defined("JOB_CATEGORY_CLIENT_MEETING")?   null: define("JOB_CATEGORY_CLIENT_MEETING", 9);

function get_job_categories($job_category_index=0)
{
  $job_category = array(
      JOB_CATEGORY_GENERAL_TASK     => 'General Task',
      JOB_CATEGORY_STRATA_CLEANING  => 'Strata Cleaning',
      JOB_CATEGORY_BIN_CLEANING     => 'Bin Cleaning',
      JOB_CATEGORY_BIN_TO_CURB      => 'Bins to curb',
      JOB_CATEGORY_METER_READING    => 'Meter Reading',
      JOB_CATEGORY_QUOTATION        => 'Quotation',
      JOB_CATEGORY_SITE_INSPECTION  => 'Site Inspection',
      JOB_CATEGORY_WINDOW_CLEANING  => 'Window Cleaning',
      JOB_CATEGORY_CLIENT_MEETING   => 'Client Meeting'
  );
  return isset($job_category[$job_category_index])?$job_category[$job_category_index]:$job_category;
}

function str_limit2($value, $length = 30, $delimiter = '...')
{
  if (strlen($value) <= $length) {
    return $value;
  }
  return substr($value, 0, $length) . '...';
}

defined("JOB_TYPE_ONE_OFF")?  null: define("JOB_TYPE_ONE_OFF", 1);
defined("JOB_TYPE_RECURRING")?   null: define("JOB_TYPE_RECURRING", 2);

function get_job_types($job_type_index=0)
{
  $job_types = array(
      JOB_TYPE_ONE_OFF    => 'One-Off',
      JOB_TYPE_RECURRING  => 'Recurring',
  );
  return isset($job_types[$job_type_index])?$job_types[$job_type_index]:$job_types;
}

function x($value)
{?>
<style>
  aside.main-sidebar {
    display: none;
}
</style>
<?php
	echo "<pre>";
	if (is_string($value)) {
		echo $value;
	}else{
		print_r($value);
	}
	echo "</pre>";
}

function set_active_menu($menu, $active_menu){
    if ( $active_menu == $menu) {
      echo 'active';
    }
}

function set_sub_menu($menu, $sub_menu){
    if ( $sub_menu == $menu) {
      echo 'active';
    }
}

function set_flash_message($title, $message){
    $ci =& get_instance();
    $ci->session->set_flashdata(['flash_title'=>$title,'flash_message'=>$message]);
}

function get_flash_message($data = array()){
    $ci =& get_instance();
    $type = array('success','info','warning','error');
    
    if (!$ci->session->flashdata('flash_title') && !$ci->session->flashdata('flash_message')) { return; }

    $title = ucfirst($type[$ci->session->flashdata('flash_title')]);
    $message = $ci->session->flashdata('flash_message');
    
    $output = "<script>
        $(function (e) {
    
            setTimeout(function() {
                toastr.options = {
                      'closeButton': true,
                      'debug': false,
                      'progressBar': true,
                      'positionClass': 'toast-bottom-right',
                      'onclick': null,
                      'showDuration': 400,
                      'hideDuration': 1000,
                      'timeOut': 50000,
                      'extendedTimeOut': 1000,
                      'showEasing': 'swing',
                      'hideEasing': 'linear',
                      'showMethod': 'fadeIn',
                      'hideMethod': 'fadeOut'
                    };
                toastr.".$type[$ci->session->flashdata('flash_title')]."('$message', '$title');

            }, 500);

        });
    </script>";

    return $output;
}

function display_document_type($ids, $values)
{
    $ids = explode(',', $ids);
    $output = array();
    foreach ($ids as $id) {
      $output[] = $values[$id];
    }
    echo join(', ', $output);
}

function local_date($date)
{
    if( !$date ){ return ''; }

    $d = DateTime::createFromFormat('Y-m-d', substr($date, 0, 10), new DateTimeZone('Australia/Melbourne'));
    $d->setTimezone(new DateTimeZone('Australia/Perth'));

    return $d->format('d/m/Y');
}

function local_datetime($date)
{
    if( !$date ){ return ''; }

    $d = new DateTime($date, new DateTimeZone('Australia/Melbourne'));
    $d->setTimezone(new DateTimeZone('Australia/Perth'));

    return $d->format('d/m/Y h:i:s a');
}

function db_date($date, $from_format='d/m/Y')
{
    $d = DateTime::createFromFormat($from_format,$date);
    return $d->format('Y-m-d');
}

function db_timestamp()
{
    return date('Y-m-d H:i:s');
}

function is_checked_item($id, $data)
{
    foreach ($data as $item) {
        if ($id == $item->consumable_id) {
            return true;
        }
    }
    return false;
}

function get_checked_item_qty($id, $field, $data)
{
    foreach ($data as $item) {
        if ($id == $item->consumable_id) {
            return $item->{$field};
        }
    }
    return '';
}

function validate_date($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}


function has_access($module_name)
{
    $CI =& get_instance();
    $role = $CI->session->userdata('user_role');
    if ( $role == ADMIN_ROLE ) {
        return true;
    }

    if ($module_name == 'dashboard') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'quotes') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'memos') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'jobs') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'vehicles') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'equipments') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'issues') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'services') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'users') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'client_types') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'clients') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'properties') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'bin_types') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'document_types') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'gallery_types') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'key_types') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'leads_types') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'suppliers') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'consumables') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'consumables_request') {
        return (($role == OFFICE_MANAGER_ROLE) || 
                ($role == OPERATION_MANAGER_ROLE) || 
                ($role == STAFF_ROLE));
    }

    if ($module_name == 'councils') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'bin_liners_management') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }

    if ($module_name == 'reports') {
        return (($role == OFFICE_MANAGER_ROLE) || ($role == OPERATION_MANAGER_ROLE));
    }
    return false;
}

function csv_download($data, $filename = "export.csv", $delimiter=";") 
{    
    header('Content-Type: application/csv');
    
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    $f = fopen('php://output', 'w');

    if ( !is_array($data) ) {
    
        write_file($f, $data);

        return;
    }

    foreach ($array as $line) {
        fputcsv($f, $line, $delimiter);
    }

}

function generate_url($url) {

    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {

        $url = "http://" . $url;

    }

    return $url;
}


function hexToRgb($hex)
{
    $colour = str_replace('#', '', $hex);

    if ( strlen( $colour ) == 6 ) {
      list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
      list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
      return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( 'r' => $r, 'g' => $g, 'b' => $b );
}

function hexToHsl($hex) {
    $hex = array($hex[0].$hex[1], $hex[2].$hex[3], $hex[4].$hex[5]);
    $rgb = array_map(function($part) {
        return hexdec($part) / 255;
    }, $hex);

    $max = max($rgb);
    $min = min($rgb);

    $l = ($max + $min) / 2;

    if ($max == $min) {
        $h = $s = 0;
    } else {
        $diff = $max - $min;
        $s = $l > 0.5 ? $diff / (2 - $max - $min) : $diff / ($max + $min);

        switch($max) {
            case $rgb[0]:
                $h = ($rgb[1] - $rgb[2]) / $diff + ($rgb[1] < $rgb[2] ? 6 : 0);
                break;
            case $rgb[1]:
                $h = ($rgb[2] - $rgb[0]) / $diff + 2;
                break;
            case $rgb[2]:
                $h = ($rgb[0] - $rgb[1]) / $diff + 4;
                break;
        }

        $h /= 6;
    }

    return array('h' => $h, 's' => $s, 'l' => $l);
}

function getDatesInBetween($from, $to, $format = "d/m/Y"){
    // $date_from = date_create_from_format($format, $from);
    $date_from = strtotime($from); // Convert date to a UNIX timestamp  
    
    // Specify the end date. This date can be any English textual format  
    // $date_to = date_create_from_format($format, $to);
    $date_to = strtotime($to); // Convert date to a UNIX timestamp  
    
    $output = [];
    // Loop from the start date to end date and output all dates inbetween  
    for ($i=$date_from; $i<=$date_to; $i+=86400)
        $output[] = date($format, $i);
    return $output;
}