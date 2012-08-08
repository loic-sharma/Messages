<?php

class Message {

	/**
	 * The currently active Swift Mailer drivers.
	 *
	 * @var array
	 */
	protected static $drivers;

	/**
	 * Get a Swift Mailer driver instance.
	 *
	 * @param  string  $driver
	 * @return Driver
	 */
	public static function instance($driver = null)
	{
		if (is_null($driver)) $driver = Config::get('messages.default', Config::get('messages::config.default'));

		if ( ! isset(static::$drivers[$driver]))
		{
			$config = Config::get('messages.transports.'.$driver, Config::get('messages::config.transports.'.$driver));

			static::$drivers[$driver] = static::factory($driver, $config);
		}

		return static::$drivers[$driver];
	}

	/**
	 * Create a new Swift Mailer driver instance.
	 *
	 * @param  string  $driver
	 * @return Driver
	 */
	protected static function factory($driver, $config)
	{	
		switch($driver)
		{
			case 'smtp':
				return new Swiftmailer\Drivers\SMTP($config);

			case 'sendmail':
				return new Swiftmailer\Drivers\Sendmail($config);

			case 'mail':
				return new Swiftmailer\Drivers\Mail($config);

			default:
				throw new Exception("Swiftmailer Driver {$driver} is not supported.");
		}
	}

	/**
	 * Magic Method for calling the methods on the default Swift Mailer
	 * driver.
	 *
	 * <code>
	 *		// Send an email
	 *		Message::instance()->send();
	 *
	 *		// Or, send an email
	 *		Message::send();
	 * </code>
	 */
	public static function __callStatic($method, $parameters)
	{
		return call_user_func_array(array(static::instance(), $method), $parameters);
	}
}