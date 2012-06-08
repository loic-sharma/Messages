<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Autoloader and dependency injection initialization for Swift Mailer.
 */

if (defined('SWIFT_REQUIRED_LOADED'))
	return;

define('SWIFT_REQUIRED_LOADED', true);

//Load Swift utility class
require Bundle::path('swiftmailer').'library'.DS.'classes'.DS.'Swift.php';

//Start the autoloader
Swift::registerAutoload();

//Load the init script to set up dependency injection
require Bundle::path('swiftmailer').'library'.DS.'swift_init.php';

// Map the Message classes.
Autoloader::map(array(
	'Message' => Bundle::path('swiftmailer').'libraries'.DS.'message.php',

	'Swiftmailer\\Drivers\\Driver'    => Bundle::path('swiftmailer').'libraries'.DS.'message'.DS.'drivers'.DS.'driver.php',
	'Swiftmailer\\Drivers\\SMTP'      => Bundle::path('swiftmailer').'libraries'.DS.'message'.DS.'drivers'.DS.'smtp.php',
	'Swiftmailer\\Drivers\\Sendmail'  => Bundle::path('swiftmailer').'libraries'.DS.'message'.DS.'drivers'.DS.'sendmail.php',
	'Swiftmailer\\Drivers\\Mail'      => Bundle::path('swiftmailer').'libraries'.DS.'message'.DS.'drivers'.DS.'mail.php',
));