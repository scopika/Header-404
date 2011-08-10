<?php
include_once(realpath(dirname(__FILE__)) . "/../../../classes/PluginsClassiques.class.php");

class Header404 extends PluginsClassiques{
    
    /**
     * Adaptation du code du fichier fonctions/moteur.php pour gérer les pages 404
     */ 
	function pre() {
		global $res, $reptpl, $fond;

		// chargement du squelette
		if($res == "") {

			$tpl = $reptpl . $fond;

			// $tpl doit impérativement être dans le répertoire $reptpl, ou un de ses sous répertoires.
			$path_tpl = realpath(dirname($tpl));
		
			$path_reptpl = realpath($reptpl);

			if (strpos($path_tpl, $path_reptpl) !== 0) {
				die("FOND Invalide: $fond");
			}

			foreach(array($tpl, $tpl.'.html') as $template) {
				if(file_exists($template)) {
					$res = file_get_contents($template);
					break;
				}
			}
			
			// page non trouvée => page 404
			if(empty($res)) {
				// Headers
				header("HTTP/1.1 404 Not Found");
				
				// On cherche un fichier 404.html dans le dossier $reptpl, sinon on prend celui fourni avec le plugin
				foreach(array($reptpl . '404.html', 'client/plugins/header404/404.html') as $template) {
					if(file_exists($template)) {
						$res = file_get_contents($template);
						break;
					}
				}
			}
		}
	}	
}
