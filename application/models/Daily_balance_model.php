<?php

/**
 * DAILY BALANCE MODAL
 */
class Daily_balance_model extends MY_Model
{
    const DB_TABLE = 'daily_balances';
    const DB_TABLE_PK = 'id';

    public $id;
    public $date;
    public $balance;
    public $notes;
    public $created_by;
    // public $added_time;
    public $updated_by;
    // public $updated_time;

}

// CREATE TABLE `jean_gex_binx`.`daily_balances` ( 
//     `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , 
//     `date` DATE NOT NULL , 
//     `balance` FLOAT NOT NULL , 
//     `notes` VARCHAR(255) NOT NULL , 
//     `created_by` INT(11) UNSIGNED NOT NULL , 
//     `created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
//     `updated_by` INT(11) UNSIGNED NULL , 
//     `updated_time` TIMESTAMP on update CURRENT_TIMESTAMP NULL ,
//     PRIMARY KEY (id)
// ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

?>