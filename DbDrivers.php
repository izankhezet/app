<?php
  namespace Model\DB;
  /**
   *
   */
  interface DbDrivers {
    public function query($request, $fetchAll = FALSE, $params = array(), $class = NULL);
    public function getPDO();
  }
