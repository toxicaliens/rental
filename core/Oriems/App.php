<?php

/***
 * The purpose of this class is to define common functions that are re-used 
 * through out the project.
 *
 * These functions have been placed here to prevent conflicts in the future as
 * the app grows.
 *
 * @author Ken Gichia <ken.gichia@obulexsolutions.com>
 */
 
use Symfony\Component\Yaml\Yaml;

class App {
	/***
	 * This function is responsible for checking if there was an ajax request.
	 */
	public static function isAjaxRequest() {
		if (
			!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		) { return true; }
		
		return false;
	}


	/***
	 * A function for starting the session if it has not started
	 */
	public static function startSession() {
		if ( !isset($_SESSION) ) session_start();
	}


	/***
	 * A function for redirecting
	 */
	public static function redirectTo($page) {
		header( "Location: $page" );
		exit;
	}


	/***
	 * A function for ensuring clean output
	 */
	public static function cleanText($input) {
		return htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
	}


	/***
	 * A function for logging out of the system
	 */
	public static function logOut() {
		// Delete the session cookie.
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		
		// Destroy session
		session_unset(); session_destroy();
		
		// Redirect to the home page
		App::redirectTo("index.php");
	}


	/***
	 * A function for including files
	 */
	public static function libInclude($arg) {
		// Get the files to include
		$files = Yaml::parse(file_get_contents( WPATH . "config/yml/include.yml" ));
		
		// Ensure that the arg was appropriately set
		if ( !isset($files[$arg]) ) return;
		
		// If the files have an output make sure to remove the necessary items
		ob_start();
		
		// Include the files
		foreach ( $files[$arg] as $p ) {
			$p = WPATH . $p;
			if ( file_exists($p) ) include_once $p;
		}
		
		// Clean output
		$content = ob_get_clean();
		if ( $content != "" ) $content = App::removeTags($content);
		if ( preg_replace('/[\s]+/S', '', $content) != "" ) echo $content;
	}
	
	
	/**
	 * A function used to define constants
	 */
	public static function defineConstants($arg) {
		// Get the files to include
		$const = Yaml::parse(file_get_contents( WPATH . "config/yml/constants.yml" ));
		
		// Ensure that the arg was appropriately set
		if ( !isset($const[$arg]) ) return;
		
		// Define each constant
		foreach ( $const[$arg] as $key=>$val ) define ($key, $val);
	}
	
	
	/**
	 * A function to remove unanted scripts and stylesheets
	 */
	public static function removeTags($content) {
		// Remove script and stylesheet tags
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				       '@<style[^>]*?>.*?</style>@siU'     // Strip style tags properly
		);
		return preg_replace($search, '', $content); 
	}
}
