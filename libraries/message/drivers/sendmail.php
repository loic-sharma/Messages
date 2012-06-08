<?php namespace Swiftmailer\Drivers;

use Swift_Message;
use Swift_SendmailTransport;

class Sendmail extends Driver {

	/**
	 * Register the Swift Mailer message and transport instances.
	 *
	 * @param  array  $config
	 * @return void
	 */
	public function __construct($config)
	{
		$this->swift = Swift_Message::newInstance();

		$this->transport = Swift_SendmailTransport::newInstance($config['command']);
	}
}