<?php

  namespace View;
  /**
   * Bootsrtap est une class conçue pour faciliter la manipulation des composants de bootstrap
   */
  class Bootstrap {

    /**
     * cette methode nous permet de creer un input de bootstrap personalise
     * @param name String nom de champ
     * @param $labelText String le text englobe dans label
     * @param $placeholder String placeholder
     * @param $type String type de champ
     * @param $value String la valeur de champ
     * @param errorMsg String le message d'erreur en cas de l suggere
     * @return êleme,t String l'element personalise
     */
    public function input($name, $labelText, $placeholder, $type = "text", $value = "", $errorMsg = null) {
      $element = (!isset($errorMsg))? "<div class=\"form-group \">" : "<div class=\"form-group has-danger\">";
      $element .= "<label for=\"$name\" class='form-control-label'>$labelText</label>
                  <input type=\"$type\" name=\"$name\" value=\"$value\" placeholder='$placeholder' id=\"$name\"";
      if(isset($errorMsg)) $element .= "class='form-control form-control-danger'/><div class=\"form-control-feedback\">$errorMsg</div>";
      else $element .= "class='form-control'/>";
      $element .= "</div>";
      return $element;
    }

    /**
     * crre un button personalise de bootstrap
     * @param $value String la valeur de button
     * @param $class String la class de button
     * @param $name nom de button
     * @param $type String type de button par defaut submit
     * @return String le button personalise
     */
    public function button ($name, $class, $value, $type = "submit") {
      return "<button style='cursor:pointer' type=\"$type\" name=\"$name\" class='$class'>$value</button>";
    }

    /**
     * entourer un element html via un div de class specifie
     * @param $htmlElment String l'element html a entoure
     * @param $class String la class html specifie de wrapper element
     * @return String element avec son parent element wrapper
     */
    public function wrap($htmlElment, $class) {
      return "<div class='$class'>" .$htmlElment. "</div>";
    }

    /**
     *
     */
    public function select($name, $labelText, $values, $valuesToShow = array(), $class = "form-control", $defaultValue = NULL) {
      $select = "<label for=\"$name\" class=\"form-control-label\">$labelText</label>";
      $select .= "<select class=\"$class\" name=\"$name\" id=\"$name\">";
      $i = 0;
      foreach ($values as $value) {
        if($value == $defaultValue) $select .= "<option value=\"$value\" selected='selected'>";
        else $select .= "<option value=\"$value\">";
        if(!empty($valuesToShow)) $select .= ucwords($valuesToShow[$i++]) . "</option>";
        else $select .= ucwords($values[$i++]) . "</option>";
      }
      $select .= '</select>';
      return $select;
    }

  }
