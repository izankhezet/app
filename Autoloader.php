<?php
  namespace Control;
  /**
   * Autoloader a pour objectif de charger les class automatiquement
   * @namespace
   */
  class Autoloader  {

    public static function register() {
      spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($className){
      if (strpos($className, __NAMESPACE__ . "\\") === 0) {
        $className = str_replace(__NAMESPACE__ . "\\", '', $className);
        $className = str_replace("\\", "/", $className);
        require "Control/" . $className . ".php";
      }
    }

  }
