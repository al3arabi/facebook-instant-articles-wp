<?php

/**
 * Instant Articles DOM Transformation Filter for headings
 *
 * @since 0.1
 */
class Instant_Articles_DOM_Transform_Filter_Heading extends Instant_Articles_DOM_Transform_Filter {

	/**
	 * Run the transformation
	 *
	 * Implements the abstract method from Instant_Articles_DOM_Transform_Filter
	 *
	 * @since 0.1
	 * @return DOMDocument
	 */
	public function run() {

		$xpath = new DOMXpath( $this->_DOMDocument );
		$DOMNodeList = $xpath->query( "//h3 | //h4 | //h5 | //h6" );

		// Transform all nodes found
		$this->_transform_elements( $DOMNodeList );

		return $this->_DOMDocument;

	}

	/**
	 * Build a DOMDocumentFragment for the element
	 *
	 * @since 0.1
	 * @return DOMDocumentFragment The fragment ready to be inserted into the DOM
	 */
	protected function _build_fragment( $properties ) {

		$DOMDocumentFragment = $this->_DOMDocument->createDocumentFragment();
		$h = $this->_DOMDocument->createElement( 'h2' );

		for ( $i = 0; $i < $properties->childNodes->length; ++$i ) {
			$h->appendChild( $properties->childNodes->item( $i ) );
		}
		
		$DOMDocumentFragment->appendChild( $h );

		return $DOMDocumentFragment;
	}

	/**
	 * Find the element properties
	 *
	 * Implements the abstract method from Instant_Articles_DOM_Transform_Filter
	 *
	 * @since 0.1
	 * @todo Get the rest of the properties
	 * @param $DOMNode  $DOMNode  The original domnode
	 */
	protected function get_properties( $DOMNode ) {

		$properties = new stdClass;

		$properties->childNodes = $DOMNode->childNodes;

		/**
		 * Filter the ol element properties
		 *
		 * @since 0.1
		 * @param object  $properties     The element properties
		 * @param int     $post_id        The post ID of the current post
		 */
		$properties = apply_filters( 'instant_articles_heading_properties', $properties, $this->_post_id );

		return $properties;

	}

}
