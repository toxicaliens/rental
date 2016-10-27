<?php

use Symfony\Component\Yaml\Yaml;

class TemplateController {
	private static $templateResource;
	
	public static function setResource($key, $val) {
		$key = strtolower($key);
		
		if (!in_array($key, array("js", "css", "args", "title", "layout"))) return;

		if (in_array($key, array("js", "css", "args"))) {
			if (is_null(self::$templateResource) || empty(self::$templateResource))
				self::$templateResource = array();

			if (!isset(self::$templateResource[$key]))
				self::$templateResource[$key] = array();

			foreach($val as $i=>$item) {
				if ( !in_array($item, self::$templateResource[$key]) ) {
					if ( in_array($key, array("js", "css")) )
						self::$templateResource[$key][] = $item;
					else if ( $key == "args" )
						self::$templateResource[$key][$i] = $item;
				}
			}
		}
		else {
			self::$templateResource[$key] = $val;
		}
	}

	public static function unsetResource($key, $val) {
		$key = strtolower($key);
		
		if (!in_array($key, array("js", "css", "args"))) return;

		foreach ( $val as $item ) {
			if(($index = array_search($item, self::$templateResource[$key])) !== false) {
				unset(self::$templateResource[$key][$index]);
			}
		}
	}

	private static function getResource($key) {
		if (is_null(self::$templateResource) || empty(self::$templateResource))
				self::$templateResource = array();
				
		// Ensure there is something to work with
		if ( isset(self::$templateResource[$key]) )
			return self::$templateResource[$key];
		return null;
	}
	
	
	public function render($page=null) {
		// Load the routing config
		$routes = Yaml::parse(file_get_contents( WPATH . "config/yml/routes.yml" ));
		
		// Default setting
		$currentRoute = '';
		
		// Get the active route
		if ( is_null($page) && isset($_GET["num"]) )
			$currentRoute = $_GET["num"];
		else if ( !is_null($page) )
			$currentRoute = $page;
		else if ( empty($_GET))
			$currentRoute = 'dashboard';
		
		// Ensure route exists
		if ( isset($routes[$currentRoute]) )
			$currentRoute = $routes[$currentRoute];
		else $currentRoute = $routes['404'];

		if($currentRoute == 'src/login.php'){
			$currentRoute = 'src/login.php';
			$this->renderPage($currentRoute);
		}else{
		
			// Show the selected page
			$result = verifyRoute($currentRoute, $_SESSION['role_id']);

			//verify the route
			if($result){
				$this->renderPage($currentRoute);
			}else{
				$currentRoute = $routes['access_denied'];
				$this->renderPage($currentRoute);
			}

		}
	}
	
	public function getMenu() {
		// Load the menu 
		$menu = $this->parseMenu("ROLE_USER");
		
		// Get the current path
		$currentUrl = "index.php";
		if ( isset($_GET["num"]) ) $currentUrl .= "?num=" . $_GET["num"];
		
		// Prepare the menu
		$menu[0]['class'] = "start";
		foreach ( $menu as $pi=>$p ) {
			$isActive = false;
			$menu["$pi"]['url'] = $p['url'];
			if ( !isset($menu["$pi"]['class']) ) $menu["$pi"]['class'] = "";
			
			if (isset($p['children'])) {
				$menu["$pi"]['class'] = isset($p['class']) ? $p['class']." has-sub": "has-sub";
				
				foreach ($menu["$pi"]['children'] as $ci=>$c) {
					$menu["$pi"]['children']["$ci"]['class'] = "";
					$menu["$pi"]['children']["$ci"]['url'] = $c['url'];
					
					if ( $currentUrl == $c['url'] ) {
						$isActive = true;
						$menu["$pi"]['children']["$ci"]['class'] = "active";
					}
				}
			}
			
			if ( $currentUrl==$menu["$pi"]['url'] || $isActive ) $menu["$pi"]['class'] .= " active";
		}
		
		// Return the prepared menu
		return $menu;
	}
	
	private function parseMenu($type) {
		$yaml = Yaml::parse(file_get_contents( WPATH . "config/yml/menu.yml" ));
		
		return isset($yaml["$type"]) ? $yaml["$type"]: $yaml["anon"];
	}
	
	private function renderPage($currentRoute) {
		// Let everything go to the buffer
		ob_start();
		include $currentRoute;
		$content = ob_get_clean();
		
		// Remove script and stylesheet tags
		$content = App::removeTags($content); 
		
		// If it is an ajax request, show the content as it is 
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			echo $content;
		}
		
		// All other requests get to be displayed using the layout defined
		else {
			// Get the defined layout
			$layout = "default-layout.php";
			if ( isset(self::$templateResource['layout']) && self::$templateResource['layout']!='' )
				$layout = self::$templateResource['layout'];
			
			// Extract args
			if ( !isset(self::$templateResource['args']) )
				self::$templateResource['args'] = array();
			extract(self::$templateResource['args']);
			
			// Show the page
			require_once WPATH . "config/template/layouts/$layout";
		}
	}
}


/***
 * Define some functions that I'll use to display the page
 */
function set_layout($layout, $args=null) {
	if (isset($layout) && is_string($layout)) {
		// Set the template
		TemplateController::setResource('layout', $layout);
		
		// Set args to be visible in template
		if (is_array($args)) 
			TemplateController::setResource('args', $args);
	}
}

function set_title($layout) {
	if (isset($layout) && is_string($layout)) 
		TemplateController::setResource('title', $layout);
}

function set_css($css) {
	if (isset($css) && is_array($css)) 
		TemplateController::setResource('css', $css);
}

function set_js($js) {
	if (isset($js) && is_array($js)) 
		TemplateController::setResource('js', $js);
}

function set_breadcrumbs($items) {
	// Ensure that the appropriate argument is passed
	if ( !is_array($items) || is_null($items) ) return '';
	$count = count($items); $i = 1;
	
	// Output buffer
	$str = '				<div class="row-fluid">
					<div class="span12">
						<ul class="breadcrumb">';

	// Iterate the array
	foreach ( $items as $item ) {
		$t = "";
		if ( $i == 1 ) $t = '<i class="icon-home"></i>';
		
		if ( !isset($item['text']) ) return '';
		
		if ( isset($item['url']) && $item['url']!='' )
			$t .= ' <a href="'.$item['url'] . '">'.$item['text'].'</a>';
		else $t .= ' <span>'.$item['text'].'</span>';
		
		if ( $i < $count ) $t .= ' <span class="icon-angle-right"></span>';
		$i++;
		
		// Append to buffer
		$str .= '
							<li> '.$t.' </li>';
	}
	
	// Close the div
		$str .= '
						</ul>
					</div>
				</div>';
	echo "$str\n";
}

function reset_layout() {
	TemplateController::setResource('layout', '');
}

function reset_title() {
	TemplateController::setResource('title', '');
}

function unset_css($css) {
	if (isset($css) && is_array($css)) 
		TemplateController::unsetResource('css', $css);
}

function unset_js($js) {
	if (isset($js) && is_array($js)) 
		TemplateController::unsetResource('js', $js);
}

