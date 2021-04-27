<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPSettingsSection;
use WaughJ\WPSettings\WPSettingsPage;

class WPSettingsOptionTest extends TestCase
{
	public function testBasic()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$option->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<input\s*type="text"\s*id="main_css"\s*name="settings_design_options\[main_css\]"\s*placeholder="Main CSS"\s*value=""\s*\/*>\s*/',
				ob_get_clean()
			)
		);
	}

	public function testCheckbox()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'show_header', 'Show Header?', [ 'input_type' => 'checkbox' ] );
		ob_start();
		$option->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<input\s*type="checkbox"\s*id="show_header"\s*name="settings_design_options\[show_header\]"\s*\/*>\s*/',
				ob_get_clean()
			)
		);
	}

	public function testTextarea()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'show_header', 'Show Header?', [ 'input_type' => 'textarea' ] );
		ob_start();
		$option->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<textarea\s*id="show_header"\s*name="settings_design_options\[show_header\]"\s*rows="10"\s*style="width:100%">\s*<\/textarea>\s*/',
				ob_get_clean()
			)
		);
	}

	public function testNumber()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'zipcode', 'Zipcode', [ 'input_type' => 'number' ] );
		ob_start();
		$option->render();
		$this->assertEquals
		(
			1,
			preg_match
			(
				'/\s*<input\s*type="number"\s*id="zipcode"\s*name="settings_design_options\[zipcode\]"\s*placeholder="Zipcode"\s*value=""\s*\/*>\s*/',
				ob_get_clean()
			)
		);
	}

	public function testSelect()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'state', 'State', [ 'input_type' => 'select', 'select_options' => [ [ 'value' => 'al', 'name' => 'Alabama' ], [ 'value' => 'ca', 'name' => 'California' ], [ 'value' => 'wa', 'name' => 'Washington' ] ] ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<select id="state" name="settings_design_options[state]"><option value="al">Alabama</option><option value="ca">California</option><option value="wa">Washington</option></select>', ob_get_clean() );
	}

	public function testCustom()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'custom', 'Custom Options' );
		$option = new WPSettingsOption( $section, 'custom', 'custom', [ 'custom_render' => function( WPSettingsOption $option ) { echo '<h1>HELLO WORLD!</h1>'; } ] );
		ob_start();
		$option->render();
		$this->assertEquals( '<h1>HELLO WORLD!</h1>', ob_get_clean() );
	}

	public function testOptionValue()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'state', 'State', [ 'input_type' => 'select', 'select_options' => [ [ 'value' => 'al', 'name' => 'Alabama' ], [ 'value' => 'ca', 'name' => 'California' ], [ 'value' => 'wa', 'name' => 'Washington' ] ] ] );
		$this->assertEquals( $option->getValue(), null );
	}
}
