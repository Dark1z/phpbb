<?php
/**
 *
 * @package testing
 * @copyright (c) 2012 phpBB Group
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

require_once __DIR__ . '/../../phpBB/includes/functions.php';
require_once __DIR__ . '/../../phpBB/includes/utf/utf_tools.php';
require_once __DIR__ . '/../../phpBB/includes/functions_upload.php';
require_once __DIR__ . '/../mock/filespec.php';

class phpbb_fileupload_test extends phpbb_test_case
{
	private $path;

	protected function setUp()
	{
		// Global $config required by unique_id
		// Global $user required by several functions dealing with translations
		global $config, $user;

		if (!is_array($config))
		{
			$config = array();
		}

		$config['rand_seed'] = '';
		$config['rand_seed_last_update'] = time() + 600;

		$user = new phpbb_mock_user();
		$user->lang = new phpbb_mock_lang();
		$this->path = __DIR__ . '/fixture/';
	}

	private function gen_valid_filespec()
	{
		$filespec = new phpbb_mock_filespec();
		$filespec->filesize = 1;
		$filespec->extension = 'jpg';
		$filespec->realname = 'valid';
		$filespec->width = 2;
		$filespec->height = 2;

		return $filespec;
	}

	protected function tearDown()
	{
		// Clear globals
		global $config, $user;
		$config = array();
		$user = null;
	}

	public function test_common_checks()
	{
		// Test 1: Valid file
		$upload = new fileupload('', array('jpg'), 1000);
		$file = $this->gen_valid_filespec();
		$upload->common_checks($file);
		$this->assertEquals(0, sizeof($file->error));

		// Test 2: File too large
		$upload = new fileupload('', array('jpg'), 100);
		$file = $this->gen_valid_filespec();
		$file->filesize = 1000;
		$upload->common_checks($file);
		$this->assertEquals('WRONG_FILESIZE', $file->error[0]);

		// Test 3: Invalid filename
		$upload = new fileupload('', array('jpg'), 100);
		$file = $this->gen_valid_filespec();
		$file->realname = 'invalid?';
		$upload->common_checks($file);
		$this->assertEquals('INVALID_FILENAME', $file->error[0]);

		// Test 4: Invalid extension
		$upload = new fileupload('', array('png'), 100);
		$file = $this->gen_valid_filespec();
		$upload->common_checks($file);
		$this->assertEquals('DISALLOWED_EXTENSION', $file->error[0]);
	}

	public function test_local_upload()
	{
		$upload = new fileupload('', array('jpg'), 1000);

		copy($this->path . 'jpg', $this->path . 'jpg.jpg');
		$file = $upload->local_upload($this->path . 'jpg.jpg');
		$this->assertEquals(0, sizeof($file->error));
		unlink($this->path . 'jpg.jpg');
	}

	public function test_valid_dimensions()
	{
		$upload = new fileupload('', false, false, 1, 1, 100, 100);

		$file1 = $this->gen_valid_filespec();
		$file2 = $this->gen_valid_filespec();
		$file2->height = 101;
		$file3 = $this->gen_valid_filespec();
		$file3->width = 0;

		$this->assertTrue($upload->valid_dimensions($file1));
		$this->assertFalse($upload->valid_dimensions($file2));
		$this->assertFalse($upload->valid_dimensions($file3));
	}
}
