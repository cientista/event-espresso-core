<?php

if (!defined('EVENT_ESPRESSO_VERSION') )
	exit('NO direct script access allowed');

/**
 * Event Espresso
 *
 * Event Registration and Management Plugin for WordPress
 *
 * @ package		Event Espresso
 * @ author			Seth Shoultes
 * @ copyright		(c) 2008-2011 Event Espresso  All Rights Reserved.
 * @ license		http://eventespresso.com/support/terms-conditions/   * see Plugin Licensing *
 * @ link			http://www.eventespresso.com
 * @ version		4.0
 *
 * ------------------------------------------------------------------------
 *
 * EE_Messages_Email_Pending_Approval_Validator class
 *
 * Holds any special validation rules for template fields with Email messenger and Pending Approval message type.
 *
 * @package		Event Espresso
 * @subpackage	core/libraries/messages/validators/email/EE_Messages_Email_Pending_Approval_Validator.class.php
 * @author		Darren Ethier
 *
 * ------------------------------------------------------------------------
 */
class EE_Messages_Email_Pending_Approval_Validator extends EE_Messages_Validator {


	public function __construct( $fields, $context ) {
		$this->_m_name = 'email';
		$this->_mt_name = 'pending_approval';

		parent::__construct( $fields, $context );
	}

	/**
	 * custom validator (restricting what was originally set by the messenger)
	 */
	protected function _modify_validator() {
		$new_config = $this->_MSGR->get_validator_config();

		//modify just event_list
		$new_config['event_list'] = array(
			'shortcodes' => array('event', 'attendee_list', 'ticket_list', 'datetime_list', 'venue', 'organization'),
			'required' => array('[EVENT_LIST]')
			);
		$this->_MSGR->set_validator_config( $new_config );
	}

} //end class EE_Messages_Email_Pending_Approval_Validator