<?php
/**
 * LP_Email_New_Order_Customer.
 *
 * @author  ThimPress
 * @package Learnpress/Classes
 * @extends LP_Email_Type_Order
 * @version 3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

if ( ! class_exists( 'LP_Email_New_Order_User' ) ) {

	/**
	 * Class LP_Email_New_Order_User
	 */
	class LP_Email_New_Order_User extends LP_Email_Type_Order {

		/**
		 * LP_Email_New_Order_User constructor.
		 */
		public function __construct() {
			$this->id          = 'new-order-user';
			$this->title       = __( 'User', 'learnpress' );
			$this->description = __( 'Send email to the user who has bought course.', 'learnpress' );

			$this->default_subject = __( 'Your order placed on {{order_date}}', 'learnpress' );
			$this->default_heading = __( 'Thank you for your order.', 'learnpress' );

			add_action( 'learn_press_order_status_draft_to_pending_notification', array( $this, 'trigger' ) );
			add_action( 'learn_press_order_status_draft_to_processing_notification', array( $this, 'trigger' ) );
			add_action( 'learn_press_order_status_draft_to_on-hold_notification', array( $this, 'trigger' ) );

			add_action( 'learn-press/order/status-pending-to-processing/notification', array( $this, 'trigger' ) );

			parent::__construct();
		}

		/**
		 * Trigger Email Notification
		 *
		 * @param int $order_id
		 *
		 * @return boolean
		 */
		public function trigger( $order_id ) {

			parent::trigger( $order_id );

			if ( ! $this->enable ) {
				return false;
			}

			$order = $this->get_order();

			if ( $order->is_guest() ) {
				return false;
			}

			$this->recipient = $order->get_user_email();

			if ( ! $this->recipient ) {
				return false;
			}

			$this->get_object();
			$this->get_variable();

			$return = $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), array(), $this->get_attachments() );

			return $return;
		}
	}
}

return new LP_Email_New_Order_User();