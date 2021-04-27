<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPSettingsSectionTest extends TestCase
{
	public function testBasic()
	{
		$page = WPSettingsPage::createForSettings( 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( 'main_scripts', $section->getSlug() );
		$this->assertEquals( WPSettingsPage::createForSettings( 'design', 'Design' ), $section->getPage() );
	}
}
