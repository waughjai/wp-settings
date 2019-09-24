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

	public function testTextarea()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'show_header', 'Show Header?', [ 'input_type' => 'textarea' ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<textarea id="show_header" name="settings_design_options[show_header]"></textarea>', ob_get_clean() );
	}

	public function testNumber()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'zipcode', 'Zipcode', [ 'input_type' => 'number' ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<input type="number" id="zipcode" name="settings_design_options[zipcode]" placeholder="Zipcode" value="" />', ob_get_clean() );
	}

	public function testSelect()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'state', 'State', [ 'input_type' => 'select', 'select_options' => [ [ 'value' => 'al', 'name' => 'Alabama' ], [ 'value' => 'ca', 'name' => 'California' ], [ 'value' => 'wa', 'name' => 'Washington' ] ] ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<select id="state" name="settings_design_options[state]"><option value="al">Alabama</option><option value="ca">California</option><option value="wa">Washington</option></select>', ob_get_clean() );
	}

	public function testCustom()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'custom', 'Custom Options' );
		$option = new WPSettingsOption( $section, 'custom', 'custom', [ 'custom_render' => function( WPSettingsOption $option ) { echo '<h1>HELLO WORLD!</h1>'; } ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<h1>HELLO WORLD!</h1>', ob_get_clean() );
	}
}
