<?php

class WPCF7_SWV_MaxNumberRule extends WPCF7_SWV_Rule {

	const rule_name = 'maxnumber';

	public function match( $context ) {
		if ( false === parent::match( $context ) ) {
			return false;
		}

		if ( empty( $context['text'] ) ) {
			return false;
		}

		return true;
	}

	public function validate( $context ) {
		$field = $this->get_property( 'field' );
		$input = isset( $_POST[$field] ) ? $_POST[$field] : '';
		$input = wpcf7_array_flatten( $input );
		$input = wpcf7_exclude_blank( $input );

		$threshold = $this->get_property( 'threshold' );

		if ( ! wpcf7_is_number( $threshold ) ) {
			return true;
		}

		foreach ( $input as $i ) {
			if ( wpcf7_is_number( $i ) and (float) $threshold < (float) $i ) {
				return new WP_Error( 'wpcf7_invalid_maxnumber',
					$this->get_property( 'error' )
				);
			}
		}

		return true;
	}

	public function to_array() {
		return array( 'rule' => self::rule_name ) + (array) $this->properties;
	}
}
