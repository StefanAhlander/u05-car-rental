<?php

namespace Main\Models;

use Main\Exceptions\NotFoundException;
use Main\Exceptions\DbException;

/**
 * Medel handling transactions with the database. Provides generic
 * methods used by child classes to indirectly storing and
 * manipulating data. This provides encapsulation and abstraction.
 */
class DataModel {
  protected $db;

  /**
   * Constructor connecting the database object to the class.
   */
  public function __construct($db) {
    $this->db = $db;
  }

  /**
   * Execute specified query. 
   * 
   * @param { $query = statement to be executed on the database.}
   * 
   * @return  { The raw results of the query.}
   */
  public function executeQuery($query, $specs = [], $amendBy = "") {
    $sth = $this->db->prepare($query . $amendBy);
    if (!$sth->execute($specs)) {
      throw new DbException($sth->errorInfo()[2]);
    }

    return $sth->fetchAll();
  }

  /**
   * Get one row from table. 
   * 
   * @param { $specs = :array containing the associative key => values to be interpolated
   *                    on the query.
   *          $specs["table] = what table to get results from,
   *          $specs["column] = what column to serch by,
   *          $specs["value"] = what value to match for.
   * 
   *          $amendBy = optional string to amend the standard query.}
   *
   * @return  { The raw results of the query.}
   */
    public function getGeneric($specs, $amendBy = "") {
    $query = "SELECT * FROM " . $specs["table"] . " WHERE " . 
              $specs["column"] . " = :value" . $amendBy;
    
    $sth = $this->db->prepare($query . $amendBy);

    if (!$sth->execute(["value" => $specs["value"]])) {
      throw new DbException($sth->errorInfo()[2]);
    }

    $results = $sth->fetchAll();

    if (empty($results)) {
      throw new NotFoundException($specs["value"] . " not found in " . $specs["column"]);
    }

    return $results[0];
  }

  /**
   * Get all rows from table. 
   * 
   * @param { $specs["table] = what table to get results from,
   *          $specs["order] = order results by.}
   * 
   * @return  { The raw results of the query.}
   */
  public function getAllGeneric($specs) {
    $query = "SELECT * FROM " . $specs["table"] . " ORDER BY " . $specs["order"];
    $sth = $this->db->prepare($query);

    if (!$sth->execute()) {
      throw new DbException($sth->errorInfo()[2]);
    }

    return $sth->fetchAll();
  }

  /**
   * Execute insert or update query. 
   * 
   * @param { $query = statement to be executed on the database,
   *          $specs = :array containing the associative key => values  to be 
   *                  interpolated on the query. Number of keys nust match
   *                  exactly to the query.}
   * 
   * @return  { The last insert id.}
   */
  public function insertOrUpdateGeneric($query, $specs) {
    $sth = $this->db->prepare($query);

    if (!$sth->execute($specs)) {
      throw new DbException($sth->errorInfo()[2]);
    }

    return $this->db->lastInsertId();
  }

  /**
   * Delete on or more rows from table. 
   * 
   * @param { $specs = :array containing the associative key => values to be interpolated
   *                    on the query.
   *          $specs["table] = what table to delete from,
   *          $specs["column] = what column to match by,
   *          $specs["value"] = what value to match for.}
   */
    public function deleteGeneric($specs) {
    $query = "DELETE FROM " . $specs["table"] . " WHERE " . 
    $specs["column"] . " = :value";
    $sth = $this->db->prepare($query);

    if (!$sth->execute(["value" => $specs["value"]])) {
      throw new DbException($sth->errorInfo()[2]);
    }
  }

  /**
   * Function to remove all occurances of a specified value from a 
   * specified table and column.
   *
   * @param { $specs = :array containing the associative key => values to be interpolated
   *                    on the query.
   *          $specs["table] = what table to modify,
   *          $specs["column] = what column to remove value from,
   *          $specs["value"] = what value to remove.}
   */
  public function removeOccurance($specs) {
    $query = "UPDATE " . $specs["table"] . " SET " . $specs["column"] .
    " = NULL WHERE "  . $specs["column"] . " = :value";   
    $sth = $this->db->prepare($query);

    if (!$sth->execute(["value" => $specs["value"]])) {
      throw new DbException($sth->errorInfo()[2]);
    }
  }

}