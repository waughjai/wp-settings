<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPSettingsSubPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPSettingsSubPageTest extends TestCase
{
	public function testBasic()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$this->assertEquals( 'settings_design_options', $page->getOptionsGroup() );
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
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertContains( '<div class="wrap">', $html );
		$this->assertContains( '<h1>Design</h1>', $html );
		$this->assertContains( '<form method="post" action="options.php">', $html );
		$this->assertContains( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
		$this->assertContains( '<input type="text" id="main_css" name="settings_design_options[main_css]" placeholder="Main CSS" value="" />', $html );
	}
}