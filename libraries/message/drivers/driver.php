<?php namespace Swiftmailer\Drivers;

use Swift_Mailer;
use Swift_Message;
use Swift_Attachment;

abstract class Driver {

	/**
	 * The instance of the Swift Mailer message.
	 *
	 * @var Swift_Mailer
	 */
	public $swift;

	/**
	 * The instance of the Swift Mailer transport.
	 *
	 * @var mixed
	 */
	public $transport;

	/**
	 * The number of successfully sent emails.
	 *
	 * @var int
	 */
	public $result;

	/**
	 * The email addresses that the message will be sent to.
	 *
	 * @var array
	 */
	public $emails = array();

	/**
	 * The email addresses that did not successfully receive the message.
	 *
	 * @var array
	 */
	public $failed = array();

	/**
	 * Register the Swift Mailer message and transport instances.
	 *
	 * @param  array  $config
	 * @return void
	 */
	abstract public function __construct($config);

	/**
	 * Prepare the Swift Message class
	 *
	 * @return Swift_Message
	 */
	public function swift()
	{
		if(is_null($this->swift))
		{
			$this->swift = Swift_Message::newInstance();
		}

		return $this->swift;
	}

	/**
	 * Set the HTML content type.
	 *
	 * @param  bool    $use_html
	 * @return Driver
	 */
	public function html($use_html = true)
	{
		$content_type = ($use_html) ? 'text/html' : 'text/plain';

		$this->swift()->setContentType($content_type);

		return $this;
	}

	/**
	 * Set the subject.
	 *
	 * @param  string  $subject
	 * @return Driver
	 */
	public function subject($subject)
	{
		$this->swift()->setSubject($subject);

		return $this;
	}

	/**
	 * Add an email address to the from list.
	 *
	 * @param  string  $email
	 * @param  string  $name
	 * @return Driver
	 */
	public function from($email, $name = null)
	{
		if( ! is_array($email))
		{
			$this->swift()->addFrom($email, $name);
		}

		else
		{
			$this->swift()->setFrom($email, $name);
		}

		return $this;
	}

	/**
	 * Add an email address to reply to.
	 *
	 * @param  string  $email
	 * @param  string  $name
	 * @return Driver
	 */
	public function reply($email, $name = null)
	{
		$this->swift()->setReplyTo($email, $name);
		
		return $this;
	}

	/**
	 * Add an email address to the list of emails to send the email to.
	 *
	 * @param  string  $email
	 * @param  string  $name
	 * @return Driver
	 */
	public function to($email, $name = null)
	{
		if( ! is_array($email))
		{
			$this->swift()->addTo($email, $name);

			$this->emails[] = $email;
		}

		else
		{
			foreach($email as $key => $value)
			{
				// If a name isn't given, the key will be an int and the value
				// will be the email address.
				if(is_int($key))
				{
					$this->emails[] = $value;

					$this->swift()->addTo($value, null);
				}

				// If a name is given, the key will be the email address and
				// the value will be the name.
				else
				{
					$this->swift()->addTo($key, $value);

					$this->emails[] = $key;
				}
			}
		}

		return $this;
	}

	/**
	 * Add an email address to the list of emails the email should be copied to.
	 *
	 * @param  string  $email
	 * @param  string  $name
	 * @return Driver
	 */
	public function cc($email, $name = null)
	{
		if( ! is_array($email))
		{
			$this->swift()->addCc($email, $name);

			$this->emails[] = $email;
		}

		else
		{
			foreach($email as $key => $value)
			{
				// If a name isn't given, the key will be an int and the value
				// will be the email address.
				if(is_int($key))
				{
					$this->emails[] = $value;

					$this->swift()->addCc($value, null);
				}

				// If a name is given, the key will be the email address and
				// the value will be the name.
				else
				{
					$this->swift()->addCc($key, $value);

					$this->emails[] = $key;
				}
			}
		}

		return $this;
	}

	/**
	 * Add an email address to the list of emails the email should be
	 * blind-copied to.
	 *
	 * @param  string  $email
	 * @param  string  $name
	 * @return Driver
	 */
	public function bcc($email, $name = null)
	{
		if( ! is_array($email))
		{
			$this->swift()->addBcc($email, $name);

			$this->emails[] = $email;
		}

		else
		{
			foreach($email as $key => $value)
			{
				// If a name isn't given, the key will be an int and the value
				// will be the email address.
				if(is_int($key))
				{
					$this->emails[] = $value;

					$this->swift()->addBcc($value, null);
				}

				// If a name is given, the key will be the email address and
				// the value will be the name.
				else
				{
					$this->swift()->addBcc($key, $value);

					$this->emails[] = $key;
				}
			}
		}

		return $this;
	}

	/**
	 * Set the body of the email.
	 *
	 * @param  string  $message
	 * @param  string  $content_type
	 * @param  string  $charset
	 * @return Driver
	 */
	public function body($message, $content_type = null, $charset = null)
	{
		$this->swift()->setBody($message, $content_type, $charset);

		return $this;
	}

	/**
	 * Attach a file to the email.
	 *
	 * @param  string  $file_path
	 * @return Driver
	 */
	public function attach($file_path)
	{
		$this->swift()->attach(Swift_Attachment::fromPath($file_path));

		return $this;
	}

	/**
	* Set a custom header
	*
	* @param  string  $header
	* @param  string  $value
	* @return Driver
	*/
	public function header($header, $value)
	{
		$this->swift()->getHeaders()->addTextHeader($header, $value);

		return $this;
	}

	/**
	 * Send the email.
	 *
	 * @return Driver
	 */
	public function send()
	{
		$mailer = Swift_Mailer::newInstance($this->transport);

		$this->result = $mailer->send($this->swift(), $this->failed);

		// Now that the email is sent, let's clear the Swift_Message instance
		// so that it can be reinstantiated later if another message is created.
		$this->swift = null;

		return $this;
	}

	/**
	 *  Get the number of successfully sent emails.
	 *
	 * @return null|int
	 */
	public function result()
	{
		return $this->result;
	}

	/**
	 * Check if at least one email was sent. If an email address is provided,
	 * this will check if the email was successfully sent to that email
	 * address
	 *
	 * @param  string  $email
	 * @return bool
	 */
	public function was_sent($email = null)
	{
		if( ! is_null($email))
		{
			$sent = array_diff($this->emails, $this->failed);

			return in_array($email, $sent);
		}

		else
		{
			if( ! is_null($this->result))
			{
				return ($this->result > 0);
			}
		}

		return false;
	}
}