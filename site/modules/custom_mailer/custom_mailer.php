<?php

/**
 * Custom Mailer
 *
 * This class acts as a separate mailer in Caracal system providing abiltiy to submit data
 * to customers API while keeping the functionalityh of the contact form module.
 *
 * Author: Mladen Mijatov
 */
require_once('mailer.php');

use Core\Module;
use Modules\CustomMailer\Mailer as Mailer;


class custom_mailer extends Module {
	private static $_instance;

	/**
	 * Constructor
	 */
	protected function __construct() {
		parent::__construct(__FILE__);

		// create new mailer
		$mailer = new Mailer();

		// register new mailer
		$contact_form = contact_form::get_instance();
		$contact_form->registerMailer('custom', $mailer);
	}

	/**
	 * Public function that creates a single instance
	 */
	public static function get_instance() {
		if (!isset(self::$_instance))
			self::$_instance = new self();

		return self::$_instance;
	}

	/**
	 * Transfers control to module functions
	 *
	 * @param array $params
	 * @param array $children
	 */
	public function transfer_control($params = array(), $children = array()) {
	}

	/**
	 * Event triggered upon module initialization
	 */
	public function initialize() {
	}

	/**
	 * Event triggered upon module deinitialization
	 */
	public function cleanup() {
	}
}
