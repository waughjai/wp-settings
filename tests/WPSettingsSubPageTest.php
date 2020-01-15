<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPSettingsSubPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPSettingsSubPageTest extends TestCase
{
	public function testOptionsGroup()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$this->assertEquals( 'settings_design_options', $page->getOptionsGroup() );
	}

	public function testGetAddPageFunction()
	{
		$settings_page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$this->assertEquals( 'add_options_page', $settings_page->getAddPageFunction() );
		$tools_page = new WPSettingsSubPage( 'tools', 'design', 'Design' );
		$this->assertEquals( 'add_management_page', $tools_page->getAddPageFunction() );
		$theme_page = new WPSettingsSubPage( 'theme', 'design', 'Design' );
		$this->assertEquals( 'add_theme_page', $theme_page->getAddPageFunction() );
	}

	public function testBasic()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertStringContainsString( '<div class="wrap">', $html );
		$this->assertStringContainsString( '<h1>Design</h1>', $html );
		$this->assertStringContainsString( '<form method="post" action="options.php">', $html );
		$this->assertStringContainsString( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
	}

	public function testWithOptions()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertStringContainsString( '<div class="wrap">', $html );
		$this->assertStringContainsString( '<h1>Design</h1>', $html );
		$this->assertStringContainsString( '<form method="post" action="options.php">', $html );
		$this->assertStringContainsString( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
		$this->assertStringContainsString( '<input type="text" id="main_css" name="settings_design_options[main_css]" placeholder="Main CSS" value="" />', $html );
	}
}
