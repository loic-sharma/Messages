<?php namespace Swiftmailer\Drivers;

use Swift_Message;
use Swift_SmtpTransport;

class SMTP extends Driver {

	/**
	 * Register the Swift Mailer message and transport instances.
	 *
	 * @param  array  $config
	 * @return void
	 */
	public function __construct($config)
	{
		$this->swift = Swift_Message::newInstance();

		$this->transport = Swift_SmtpTransport::newInstance()
							->setHost($config['host'])
							->setPort($config['port'])
							->setUsername($config['username'])
							->setPassword($config['password'])
							->setEncryption($config['encryption']);
	}
}