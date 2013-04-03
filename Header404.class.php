<?php
include_once(realpath(dirname(__FILE__)) . "/../../../classes/PluginsClassiques.class.php");

class Header404 extends PluginsClassiques
{

    /**
     * Adaptation du code du fichier fonctions/moteur.php pour gérer les pages 404
     * En cas d'erreur, on laisse la main au moteur Thelia
     */
    function pre()
    {
        global $res, $reptpl, $fond;

        // chargement du squelette
        if ($res == "") {

            $tpl = $reptpl . $fond;

            // $tpl doit impérativement être dans le répertoire $reptpl, ou un de ses sous répertoires.
            $path_tpl = rtrim(dirname($tpl), '/');
            $path_reptpl = rtrim($reptpl, '/');
            if (strpos($path_tpl, $path_reptpl) !== 0) return; // on laisse la main au moteur Thelia

            $tpl = realpath(dirname(__FILE__) . '/../../../') . '/' . $tpl;

            if (file_exists($tpl)) return;
            if (file_exists($tpl . '.html')) return;

            // page non trouvée => page 404
            header("HTTP/1.1 404 Not Found");
            // On cherche un fichier 404.html dans le dossier $reptpl, sinon on prend celui fourni avec le plugin
            foreach (array($reptpl . '404.html', 'client/plugins/header404/404.html') as $template) {
                if (file_exists($template)) {
                    $res = file_get_contents($template);
                    break;
                }
            }
        }
    }
}
