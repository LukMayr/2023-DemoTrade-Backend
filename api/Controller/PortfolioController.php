<?php

use util\HttpErrorCodes;
require_once '../utils/Response.php';
require_once '../Connection.php';


class PortfolioController
{
    private static ?mysqli $db = null;
    private static ?PortfolioController $instance = null;

    public static function getInstance(): PortfolioController
    {
        if (self::$instance == null) {
            self::$instance = new PortfolioController();
        }
        return self::$instance;
    }

    private function __construct()
    {
        self::$db = Connection::getConnection();
    }

    public function getAllPortfoliosByUserId($userId)
    {
        $statement = "SELECT p_id, p_u_id, p_c_id FROM dt_portfolio WHERE p_u_id = $userId;";
        $res = self::$db->query($statement);

        $portfolios = [];
        while ($row = $res->fetch_assoc()) {
            $portfolios[] = $row;
        }

        if (empty($portfolios)) {
            Response::error(HttpErrorCodes::HTTP_NOT_FOUND, "No repositories found for the user")->send();
        }

        $portfolioDetails = [];
        foreach ($portfolios as $portfolio) {
            $portfolioId = $portfolio['p_id'];
            $portfolioDetails[$portfolioId] = $this->getPortfolioDetails($portfolioId);
        }

        Response::ok("Repositories found", $portfolioDetails)->send();
    }

    private function getPortfolioDetails($portfolioId): array
    {
        // Perform additional queries or logic to fetch portfolio details based on the given portfolioId
        // Return the portfolio details as needed

        // Example code to fetch portfolio details
        $statement = "SELECT * FROM dt_portfoliository WHERE p_id = $portfolioId;";
        $res = self::$db->query($statement);

        $portfolioDetails = [];
        while ($row = $res->fetch_assoc()) {
            $portfolioDetails[] = $row;
        }

        return $portfolioDetails;
    }

    public function createPortfolio($userId, $currencyId)
    {
        $statement = "INSERT INTO dt_portfolio (p_u_id, p_c_id) VALUES ($userId, $currencyId);";

        if (self::$db->query($statement)) {
            Response::created("Portfolio created")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Portfolio not created")->send();
        }
    }

    public function deletePortfolio($Id)
    {
        $statement = "DELETE FROM dt_portfolio WHERE p_u_id = $Id;";

        if (self::$db->query($statement)) {
            Response::ok("Portfolio deleted")->send();
        } else {
            Response::error(HttpErrorCodes::HTTP_INTERNAL_SERVER_ERROR, "Portfolio not deleted")->send();
        }
    }

    public function getPortfoliosById($id)
    {
        $statement = "SELECT * FROM dt_portfolio WHERE p_u_id = $id;";
        $res = self::$db->query($statement);

        $myArray = [];
        while ($row = $res->fetch_assoc()) {
            $myArray[] = $row;
        }

        if (empty($myArray)) {
            Response::error(HttpErrorCodes::HTTP_NOT_FOUND, "Portfolios not found")->send();
        }
        Response::ok("Portfolios found", $myArray)->send();
    }
}
