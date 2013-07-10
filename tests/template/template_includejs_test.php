<?php
/**
*
* @package testing
* @copyright (c) 2011 phpBB Group
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

require_once dirname(__FILE__) . '/template_test_case_with_tree.php';

class phpbb_template_template_includejs_test extends phpbb_template_template_test_case_with_tree
{
	public function template_data()
	{
		return array(
			/*
			array(
				// vars
				// expected
			),
			*/
			array(
				array('TEST' => 1),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/parent_and_child.js?assets_version=1"></script>',
			),
			array(
				array('TEST' => 2),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/parent_and_child.js?assets_version=0&assets_version=1"></script>',
			),
			array(
				array('TEST' => 3),
			'<script type="text/javascript" src="' . $this->test_path . '/templates/parent_and_child.js?test=1&assets_version=0&assets_version=1"></script>',
			),
			array(
				array('TEST' => 4),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/parent_and_child.js?test=1&amp;assets_version=0&assets_version=1"></script>',
			),
			array(
				array('TEST' => 5),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/parent_and_child.js?test=1;assets_version=0&assets_version=1"></script>',
			),
			array(
				array('TEST' => 6),
				'<script type="text/javascript" src="' . $this->test_path . '/parent_templates/parent_only.js?assets_version=1"></script>',
			),
			array(
				array('TEST' => 7),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/child_only.js?assets_version=1"></script>',
			),
			array(
				array('TEST' => 8),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/subdir/parent_only.js?assets_version=1"></script>',
			),
			array(
				array('TEST' => 9),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/subdir/subsubdir/parent_only.js?assets_version=1"></script>',
			),
			array(
				array('TEST' => 10),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/subdir/parent_only.js?assets_version=1"></script>',
			),
			array(
				array('TEST' => 11),
				'<script type="text/javascript" src="' . $this->test_path . '/templates/child_only.js?test1=1&amp;test2=2&assets_version=1#test3"></script>',
			),
			array(
				array('TEST' => 12),
				'<script type="text/javascript" src="' . $this->test_path . '/parent_templates/parent_only.js?test1=1&amp;test2=2&assets_version=1#test3"></script>',
			),
			array(
				array('TEST' => 13),
				'<script type="text/javascript" src="' . $this->test_path . '/parent_templates/parent_only.js?test1=1;test2=2&assets_version=1#test3"></script>',
			),
			array(
				array('TEST' => 14),
				'<script type="text/javascript" src="' . $this->test_path . '/parent_templates/parent_only.js?test1=&quot;&assets_version=1#test3"></script>',
			),
			array(
				array('TEST' => 15),
				'<script type="text/javascript" src="http://phpbb.com/b.js?c=d&assets_version=1#f"></script>',
			),
			array(
				array('TEST' => 16),
				'<script type="text/javascript" src="http://phpbb.com/b.js?c=d&assets_version=1&assets_version=1#f"></script>',
			),
		);
	}

	/**
	* @dataProvider template_data
	*/
	public function test_includejs_compilation($vars, $expected)
	{
		// Reset the engine state
		$this->setup_engine(array('assets_version' => 1));

		$this->template->assign_vars($vars);

		// Run test
		$this->run_template('includejs.html', array_merge(array('PARENT' => 'parent_only.js', 'SUBDIR' => 'subdir', 'EXT' => 'js'), $vars), array(), array(), $expected);
	}
}
