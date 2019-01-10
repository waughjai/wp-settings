<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsSubPage;
use WaughJ\WPSettings\WPSettingsSubPageManager;

class WPSettingsSubPageManagerTest extends TestCase
{
	public function testStart()
	{
		$this->assertEquals( null, WPSettingsSubPageManager::get( 'settings', 'design' ) );
	}

	public function testBasic()
	{
		$page = WPSettingsSubPageManager::initializeIfNotAlreadyInitialized( 'settings', 'design', 'Design' );
		$this->assertEquals( new WPSettingsSubPage( 'settings', 'design', 'Design' ), $page );
	}

	public function testStillWorks()
	{
		$this->assertEquals( new WPSettingsSubPage( 'settings', 'design', 'Design' ), WPSettingsSubPageManager::get( 'settings', 'design' ) );
	}
}
