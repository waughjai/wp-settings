<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPSettingsSection;
use WaughJ\WPSettings\WPSettingsSubPage;

class WPSettingsOptionTest extends TestCase
{
	public function testBasic()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$option->render();
		$this->assertEquals( '<input type="text" id="main_css" name="settings_design_options[main_css]" placeholder="Main CSS" value="" />', ob_get_clean() );
	}

	public function testCheckbox()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'show_header', 'Show Header?', [ 'input_type' => 'checkbox' ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<input type="checkbox" id="show_header" name="settings_design_options[show_header]" />', ob_get_clean() );
	}
}
