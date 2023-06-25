<?php

use util\HttpErrorCodes;

class StockController
{
    private static ?mysqli $db = null;
    private static ?StockController $instance = null;

    public static function getInstance(): StockController
    {
        if (self::$instance == null) {
            self::$instance = new StockController();
        }
        return self::$instance;
    }

    private function __construct()
    {
        self::$db = Connection::getConnection();
    }

    public function createStock($portfolioId, $quantity, $price, $currencyId)
    {
        if ($portfolioId == null || $quantity == null || $price == null) {
            Response::error(HttpErrorCodes::HTTP_BAD_REQUEST, "Missing parameters")->send();
        }

        $statement = "INSERT INTO dt_stock (s_c_id,s_p_id, s_quantity, s_price) VALUES ($currencyId, $portfolioId, $quantity, $price);";
        if (self::$db->query($statement)) {
            $stockId = self::$db->insert_id;
            $this->getStockById($stockId, $portfolioId);
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Stock not created")->send();
        }
    }

    public function getStockById($stockId, $portfolioId)
    {
        $statement = "SELECT * FROM dt_stock WHERE s_id = $stockId AND S_P_ID = $portfolioId;";
        $res = self::$db->query($statement);

        if ($res->num_rows == 0) {
            Response::error(HttpErrorCodes::HTTP_NOT_FOUND, "Stock not found")->send();
        }

        $stock = $res->fetch_assoc();
        Response::ok("Stock found", $stock)->send();
    }

    public function buyStock($stockName,$portfolioId,$quantity, $price)
    {
        $statement  = "select c_id from DT_CURRENCY where c_name = '$stockName';";
        $res = self::$db->query($statement);
        $row = $res->fetch_assoc();
        $currencyId = $row['c_id'];
        $statement = "SELECT s_quantity FROM dt_stock WHERE S_C_ID = $currencyId AND S_P_ID = $portfolioId;";
        $res = self::$db->query($statement);

        if ($res->num_rows == 0) {
            $this->createStock($portfolioId, $quantity, $price, $currencyId);
        }

        $row = $res->fetch_assoc();
        $currentQuantity = $row['s_quantity'];
        $newQuantity = $currentQuantity + $quantity;

        $statement = "UPDATE dt_stock SET s_quantity = $newQuantity WHERE s_id = $;";
        if (self::$db->query($statement)) {
            Response::ok("Stock bought")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Failed to buy stock")->send();
        }
    }

    public function sellStock($stockId, $quantity)
    {
        $statement = "SELECT s_quantity FROM dt_stock WHERE s_id = $stockId;";
        $res = self::$db->query($statement);

        if ($res->num_rows == 0) {
            Response::error(\util\HttpErrorCodes::HTTP_NOT_FOUND, "Stock not found")->send();
        }

        $row = $res->fetch_assoc();
        $currentQuantity = $row['s_quantity'];

        if ($quantity > $currentQuantity) {
            Response::error(\util\HttpErrorCodes::HTTP_BAD_REQUEST, "Insufficient quantity to sell")->send();
        }

        $newQuantity = $currentQuantity - $quantity;

        $statement = "UPDATE dt_stock SET s_quantity = $newQuantity WHERE s_id = $stockId;";
        if (self::$db->query($statement)) {
            Response::ok(\util\HttpErrorCodes::HTTP_OK, "Stock sold")->send();
        } else {
            Response::error(\util\HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Failed to sell stock")->send();
        }
    }

    public function deleteStock($stockId)
    {
        $statement = "DELETE FROM dt_stock WHERE s_id = $stockId;";
        if (self::$db->query($statement)) {
            Response::ok(\util\HttpErrorCodes::HTTP_OK ,"Stock deleted")->send();
        } else {
            Response::error(\util\HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Stock not deleted")->send();
        }
    }

    public function getAllByPortfolioId($portfolioId)
    {
        $statement = "SELECT * FROM DT_STOCK WHERE S_P_ID = $portfolioId;";
        $res = self::$db->query($statement);

        $stocks = array();
        while ($row = $res->fetch_assoc()) {
            array_push($stocks, $row);
        }

        Response::ok("Stocks found", $stocks)->send();
    }
}