<?php namespace spec\Hakim\Backup;

use PhpSpec\ObjectBehavior;
use Mockery;

class BackupFilesystemSpec extends ObjectBehavior {

	function it_is_initializable()
	{
		$this->shouldHaveType('Cornford\Backup\Contracts\BackupFilesystemInterface');
	}

}
