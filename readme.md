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

Sending a message couldn't be easier.

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');

	$message->subject('Hello!');
	$message->body('Well hello Someone, how is it going?');
});

```

Or, you can simply cain the methods directly from the class.

```php

<?php

Message::to('someone@gmail.com')
	->from('me@gmail.com', 'Bob Marley')
	->subject('Hello!')
	->body('Well hello Someone, how is it going?')
	->send();

```

### Sending an email with HTML

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');
	$message->subject('Hello!');

	$message->body('Well hello <b>Someone</b>, how is it going?');

	$message->html(true);
});

```

### Using Views

Emails with HTML can become quite cumbersome. Therefore, it is recommended that
you store your emails in views.

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');

	$message->subject('Hello!');
	$message->body('view: emails.hello');

	// You can add View data by simply setting the value
	// to the message.
	$message->name = 'Someone';

	$message->html(true);
});

```

### Checking if the message was sent

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');

	$message->subject('Hello!');
	$message->body('Well hello Someone, how is it going?');
});

if(Message::was_sent())
{
	echo 'Sweet it worked!';
}

```

### Checking if a specific email received the message

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');

	$message->subject('Hello!');
	$message->body('Well hello Someone, how is it going?');
});

if(Message::was_sent('someone@gmail.com'))
{
	echo 'Sweet, Someone got the email!';
}

```

### Sending an email with an attachment

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');

	$message->subject('Hello!');
	$message->body('Well hello Someone, how is it going?');

	$message->attach('/path/to/file.extension');
});

```

### Sending emails to multiple email addresses

```php
<?php

Message::send(function($message)
{
	$message->to(array('someone@gmail.com', 'email@address.com' => 'name'));
	$message->cc('more@addresses.com');
	$messages->bcc(array('evenmore@address.com' => 'Another name', 'onelast@address.com'));

	$message->from('me@gmail.com', 'Bob Marley');
	$message->subject('Hello!');
	$message->body('I really like spamming people!');
});

```

### Sending an email with a reply address

```php
<?php

Message::send(function($message)
{
	$message->to('someone@gmail.com');
	$message->from('me@gmail.com', 'Bob Marley');
	$message->reply('replytome@gmail.com');

	$message->subject('Hello!');
	$message->body('Well hello Someone, how is it going?');
});

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