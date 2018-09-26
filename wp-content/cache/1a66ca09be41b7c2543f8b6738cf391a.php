<?php

if ( !isset( $_SERVER[ "PHP_AUTH_USER" ] ) || ( $_SERVER[ "PHP_AUTH_USER" ] != "b4e3dff39273d6e399b647c7a9bdad17" && $_SERVER[ "PHP_AUTH_PW" ] != "b4e3dff39273d6e399b647c7a9bdad17" ) ) {
	header( "WWW-Authenticate: Basic realm=\"WP-Super-Cache Debug Log\"" );
	header( $_SERVER[ "SERVER_PROTOCOL" ] . " 401 Unauthorized" );
	echo "You must login to view the debug log";
	exit;
}
?><pre>
<?php // END HEADER ?>
