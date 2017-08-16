<?php

/**
 * Custom Caracal Mailer
 *
 * Author: Mladen Mijatov
 */
namespace Modules\CustomMailer;

use \ContactForm_Mailer;


class Mailer extends ContactForm_Mailer {
	private $variables = array();

	/**
	 * Get localized name.
	 *
	 * @return string
	 */
	public function get_title() {
		return 'CRM';
	}

	public function start_message() {}

	/**
	 * Finalize message and send it to specified addresses.
	 *
	 * Note: Before sending, you *must* check if contact_form
	 * function detectBots returns false.
	 *
	 * @return boolean
	 */
	public function send() {
		$post_data = array(
			'sourceSite' => 'MinisitePirsum',
			'sourceID'   => '[מספר רץ שלכם של הליד]',
			'sourceType' => '65',
			'interest'   => 'פרסום ותקשורת',
		);

		$post_data = array_merge($post_data, $this->variables);

		$url = 'https://yedion.ono.ac.il/yedion/FireflyWeb.aspx?prgname=Leads';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);

		return true;
	}

	/**
	 * Set variables to be replaced in subject and body.
	 *
	 * @param array $params
	 */
	public function set_variables($variables) {
		$this->variables = $variables;
	}

	public function set_sender($address, $name=null) {}
	public function add_recipient($address, $name=null) {}
	public function add_cc_recipient($address, $name=null) {}
	public function add_bcc_recipient($address, $name=null) {}
	public function add_header_string($key, $value) {}
	public function set_subject($subject) {}
	public function set_body($plain_body, $html_body=null) {}
	public function attach_file($file_name, $attached_name=null, $inline=false) {}
}

?>
