<?php
/**
*
* @package migration
* @copyright (c) 2012 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License v2
*
*/

class phpbb_db_migration_data_3_0_5_rc1part2 extends phpbb_db_migration
{
	function depends_on()
	{
		return array('phpbb_db_migration_data_3_0_5_rc1');
	}

	function update_schema()
	{
		return array(
			'drop_keys'			=> array(
				ACL_OPTIONS_TABLE		=> array('auth_option'),
			),
			'add_unique_index'	=> array(
				ACL_OPTIONS_TABLE		=> array(
					'auth_option'		=> array('auth_option'),
				),
			),
		);
	}

	function update_data()
	{
		return array(
			array('config.update', array('version', '3.0.5-rc1')),
		);
	}
}
