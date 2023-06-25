<?php

use util\HttpErrorCodes;

class CurrencyController
{
  private static ?mysqli $db = null;
  private static ?CurrencyController $instance = null;

  public static function getInstance(): CurrencyController
  {
    if (self::$instance == null) {
      self::$instance = new CurrencyController();
    }
    return self::$instance;
  }

  private function __construct()
  {
    self::$db = Connection::getConnection();
  }

  public function getAllCurrencies(): array {
    $statement = "SELECT * FROM dt_currency;";
    $res = self::$db->query($statement);

    if ($res->num_rows == 0) {
      Response::error(HttpErrorCodes::HTTP_NOT_FOUND, "Currencies not found")->send();
    }

    $currencies = array();
    while ($row = $res->fetch_assoc()) {
      array_push($currencies, $row);
    }

    return $currencies;
  }
}
