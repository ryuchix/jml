<?php 

require_once 'application/models/Dashboard_table_base_model.php';

/**
* Fetch all services data for equipments
*/
class Dashboard_equipment_information_model extends Dashboard_table_base_model
{
	private $query = "";
	
	function __construct()
	{
		$this->query = "
			SELECT
			    equipment.id,
			    equipment.name,
			    equipment.image,
			    equipment_type.type,
			    service.booked_date,
			    service.next_service_date,
    			CONCAT(users.first_name, ' ', users.last_name) AS assigned_user
			FROM
			    equipment
			JOIN equipment_type ON equipment_type.id = equipment.equipment_type_id AND equipment.active = 1
			LEFT JOIN(
			    SELECT
			        last_equipment_service.id,
			        last_equipment_service.equipment_id,
			        last_equipment_service.booked_date,
			        last_equipment_service.next_service_date
			    FROM
			        equipment_tags AS last_equipment_service
                WHERE booked_date = ( SELECT MAX(b.booked_date) FROM equipment_tags AS b
    						WHERE last_equipment_service.equipment_id = b.equipment_id )
			    GROUP BY
			        last_equipment_service.equipment_id
			) AS service
			ON
			    service.equipment_id = equipment.id
			LEFT JOIN users ON users.id = equipment.assigned
		";
	}

	public function get()
	{
        return $this->get_result($this->query);
	}

	public function get_next_service_highlighted_class()
	{
		return $this->get_class_based_on_date($this->next_service_date);
	}

}


