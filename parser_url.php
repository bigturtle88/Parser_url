<?php

require_once( "simple_html_dom.php" );

class PageDownload {

	private $url;
	private $handle;

	protected static $_instance;

	private function __construct() {
	}

	private function __clone() {
	}

	private function  __sleep() {
	}

	private function  __wakeup() {
	}

	public static function getInstance() {

		if ( null === self::$_instance ) {

			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function action( $url = null ) {

		$ValidationUrl = new ValidationUrl();


		if ( null != $ValidationUrl->action( $url ) ) {


			return self::download( $url );

		} else {
			echo null;
		}

	}

	private function download( $url ) {

		$handle = file_get_contents( $url );

		return $handle;

	}

}

class ValidationUrl {

	private $url;

	public function __construct() {
	}

	public function action( $url = null ) {


		try {
			if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {

				return $url;

			} else {
				throw new Exception( 'Error Url' );
			}

		} catch
		( Exception $e ) {
			echo $e->getMessage();

			return null;
		}


	}

}

class ParseUrl {

	private $content;
	private $links = array();
	private $html;

	public function __construct() {
	}

	public function action( $content = null ) {

		$html = str_get_html( $content );


		foreach ( $html->find( 'a' ) as $e ) {
			$links[] = parse_url( $e->href )["host"];


		}

		$links = array_unique( $links );

		return $links;

	}
}

Class PrintUrl {
	private $links;

	public function __construct() {
	}

	public function action( $links = null ) {

		foreach ( $links as $link ) {


			echo $link;
			echo "\n";


		}
	}


}


if ( $argc != 1 ) {

	$url = $argv[1];

	$PageDownload = PageDownload::getInstance();
	$Page         = $PageDownload->action( $url );
	$Links        = new ParseUrl();
	$LinksResult  = $Links->action( $Page );
	$PrintUrl     = new PrintUrl();
	$PrintUrl->action( $LinksResult );


} else {

	echo 'Error data';
}


