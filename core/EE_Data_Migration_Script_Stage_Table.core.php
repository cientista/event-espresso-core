<?php
if ( ! defined('EVENT_ESPRESSO_VERSION')) {
	exit('No direct script access allowed');
}

/**
 * Class EE_Data_Migration_Script_Stage_Table
 *
 * Migration stages which simply cycle through all the rows of an old table and somehow migrate them to the new DB
 * should probably extend Stage_Table in order to avoid code repetition. To extend this, implement the _migrate_old_row() method,
 * and create a constructor which defines $this->_old_table to be the name of the old table.
 *
 * @package 			Event Espresso
 * @subpackage 	core
 * @author 				Mike Nelson
 * @since                4.0
 *
 */
abstract class EE_Data_Migration_Script_Stage_Table extends EE_Data_Migration_Script_Stage {

	protected $_old_table;



	/**
	 * IMPORTANT: if an error is encountered, or everything is finished, this stage should update its status property accordingly.
	 * Note: it should not alter the count of items migrated. That is done in the public function that calls this.
	 * IMPORTANT: The count of items migrated should ONLY be less than $num_items_to_migrate when it's the last migration step, otherwise it
	 * should always return $num_items_to_migrate. (Eg, if we're migrating attendees rows from the database, and $num_items_to_migrate is set to 50,
	 * then we SHOULD actually migrate 50 rows,but at very least we MUST report/return 50 items migrated)
	 *
	 * @param int $num_items
	 * @return int number of items ACTUALLY migrated
	 */
	function _migration_step($num_items=50){
		global $wpdb;
		$start_at_record = $this->count_records_migrated();
		$rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $this->_old_table LIMIT %d,%d", $start_at_record, $num_items ), ARRAY_A );
		$items_actually_migrated = 0;
		foreach($rows as $old_row){
			$this->_migrate_old_row($old_row);
			$items_actually_migrated++;
		}
		if($this->count_records_migrated() + $items_actually_migrated >= $this->count_records_to_migrate()){
			$this->set_completed();
		}
		return $items_actually_migrated;
	}



	/**
	 * Counts the records to migrate; the public version may cache it
	 * @return int
	 */
	function _count_records_to_migrate() {
		global $wpdb;
		$count = $wpdb->get_var( "SELECT COUNT(*) FROM $this->_old_table" );
		return $count;
	}

	/**
	 * takes care of migrating this particular row from the OLD table to whatever its
	 * representation is in the new database. If there are errors, use $this->add_error to log them. If there is a fatal error
	 * which prevents all future migrations, throw an exception describing it
	 * @param array $old_row an associative array where keys are column names and values are their values.
	 * @return null
	 */
	abstract protected function _migrate_old_row($old_row);



}
// end of file: /core/EE_Data_Migration_Script_Stage_Table.core.php