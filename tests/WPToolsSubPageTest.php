<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPToolsSubPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPToolsSubPageTest extends TestCase
{
	public function testOptionsGroup()
	{
		$page = new WPToolsSubPage( 'design', 'Design' );
		$this->assertEquals( 'tools_design_options', $page->getOptionsGroup() );
	}

	public function testGetAddPageFunction()
	{
		$tools_page = new WPToolsSubPage( 'design', 'Design' );
		$this->assertEquals( 'add_management_page', $tools_page->getAddPageFunction() );
	}

	public function testBasic()
	{
		$page = new WPToolsSubPage( 'design', 'Design' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertContains( '<div class="wrap">', $html );
		$this->assertContains( '<h1>Design</h1>', $html );
		$this->assertContains( '<form method="post" action="options.php">', $html );
		$this->assertContains( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
	}

	public function testWithOptions()
	{
		$page = new WPToolsSubPage( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertContains( '<div class="wrap">', $html );
		$this->assertContains( '<h1>Design</h1>', $html );
		$this->assertContains( '<form method="post" action="options.php">', $html );
		$this->assertContains( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
		$this->assertContains( '<input type="text" id="main_css" name="tools_design_options[main_css]" placeholder="Main CSS" value="" />', $html );
	}
}
