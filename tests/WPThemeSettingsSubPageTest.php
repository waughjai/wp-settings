<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsOption;
use WaughJ\WPSettings\WPThemeSettingsSubPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPThemeSettingsSubPageTest extends TestCase
{
	public function testOptionsGroup()
	{
		$page = new WPThemeSettingsSubPage( 'design', 'Design' );
		$this->assertEquals( 'theme_design_options', $page->getOptionsGroup() );
	}

	public function testGetAddPageFunction()
	{
		$theme_page = new WPThemeSettingsSubPage( 'design', 'Design' );
		$this->assertEquals( 'add_theme_page', $theme_page->getAddPageFunction() );
	}

	public function testBasic()
	{
		$page = new WPThemeSettingsSubPage( 'design', 'Design' );
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
		$page = new WPThemeSettingsSubPage( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertStringContainsString( '<div class="wrap">', $html );
		$this->assertStringContainsString( '<h1>Design</h1>', $html );
		$this->assertStringContainsString( '<form method="post" action="options.php">', $html );
		$this->assertStringContainsString( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
		$this->assertStringContainsString( '<input type="text" id="main_css" name="theme_design_options[main_css]" placeholder="Main CSS" value="" />', $html );
	}
}
