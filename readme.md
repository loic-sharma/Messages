# [Swift Mailer](http://swiftmailer.org) Laravel Bundle

The power of Swift Mailer with the beauty of Laravel.

## Installation

Install using the Artian CLI:

	php artisan bundle:install messages

then edit **application/bundles.php** to autoload messages:

```php
<?php

return array(

'messages' => array(
	'auto' => true
),

```
	
You can then set your configuration at **config/config.php**.

## A Few Examples

### Changing configurations in runtime

```php
<?php

Config::set('messages::config.transports.smtp.host', 'smtp.gmail.com');
Config::set('messages::config.transports.smtp.port', 465);
Config::set('messages::config.transports.smtp.username', 'someone@gmail.com');
Config::set('messages::config.transports.smtp.password', 'password');
Config::set('messages::config.transports.smtp.encryption', 'ssl');

```

### Sending a message:

```php
<?php

Message::to('someone@gmail.com')
	->from('me@gmail.com', 'Bob Marley')
	->subject('Hello!')
	->body('Well hello Someone, how is it going?')
	->send();
```

### Checking if the message was sent

```php
<?php

$message = Message::to('someone@gmail.com')
			->from('me@gmail.com', 'Bob Marley')
			->subject('Hello!')
			->body('Well hello Someone, how is it going?')
			->send();

if($message->was_sent())
{
	echo 'Sweet it worked!';
}

// Or:
if(Message::was_sent())
{
	echo 'Sweet it worked!';
}
```

### Checking if a specific email received the message

```php
<?php

$message = Message::to('someone@gmail.com')
			->from('me@gmail.com', 'Bob Marley')
			->subject('Hello!')
			->body('Well hello Someone, how is it going?')
			->send();

if($message->was_sent('someone@gmail.com'))
{
	echo 'Sweet, Someone got the email!';
}
```

### Sending an email with an attachment

```php
<?php

Message::to('someone@gmail.com')
	->from('me@gmail.com')
	->subject('Hello!')
	->body('Well hello Someone, how is it going?')
	->attach('/path/to/file.txt')
	->send();
```

### Sending an email with HTML

```php
<?php

Message::to('someone@gmail.com')
	->from('me@gmail.com')
	->subject('Hello!')
	->body('Well hello <b>Someone</b>, how is it going?')
	->html(true)
	->send();
```

### Sending emails to multiple email addresses

```php
<?php

Message::to(array('someone@gmail.com', 'email@address.com' => 'name'))
	->cc('more@addresses.com')
	->bcc(array('evenmore@address.com' => 'Another name', 'onelast@address.com'))
	->subject('Hello Guys!')
	->body('I really like spamming people!')
	->send(); 
```

## Swift Mailer, by Chris Corbyn

Swift Mailer is a component based mailing solution for PHP 5.
It is released under the LGPL license.

- Homepage:      http://swiftmailer.org
- Documentation: http://swiftmailer.org/docs
- Mailing List:  http://groups.google.com/group/swiftmailer
- Bugs:          https://github.com/swiftmailer/swiftmailer/issues
- Repository:    https://github.com/swiftmailer/swiftmailer

Swift Mailer is highly object-oriented by design and lends itself
to use in complex web application with a great deal of flexibility.

For full details on usage, see the documentation.