<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If class `Jet_Reset_Restore_Hooks` doesn't exists yet.
if ( ! class_exists( 'Jet_Reset_Restore_Hooks' ) ) {

	class Jet_Reset_Restore_Hooks {

		public $hooks = array();
		
		public $hook_name       = null;
		public $reset_on_hook   = null;
		public $restore_on_hook = null;

		public function __construct( $hook_name, $reset_on_hook, $restore_on_hook ) {

			$this->hook_name       = $hook_name;
			$this->reset_on_hook   = $reset_on_hook;
			$this->restore_on_hook = $restore_on_hook;

			add_action( $this->reset_on_hook, array( $this, 'reset_hooks' ) );
			add_action( $this->restore_on_hook, array( $this, 'restore_hooks' ) );

		}

		public function reset_hooks() {

			global $wp_filter;
			$raw_hooks = isset( $wp_filter[ $this->hook_name ] ) && ! empty( $wp_filter[ $this->hook_name ]->callbacks ) ? $wp_filter[ $this->hook_name ]->callbacks : array();

			foreach ( $raw_hooks as $priority => $callbacks ) {
				foreach ( $callbacks as $callback ) {
					$this->hooks[] = array(
						'function'      => $callback['function'],
						'priority'      => $priority,
						'accepted_args' => $callback['accepted_args'],
					);
				}
			}

			remove_all_filters( $this->hook_name );

		}

		public function restore_hooks() {

			if ( ! empty( $this->hooks ) ) {
				foreach ( $this->hooks as $callback ) {
					add_filter( $this->hook_name, $callback['function'], $callback['priority'], $callback['accepted_args'] );
				}
			}

		}

	}

}
