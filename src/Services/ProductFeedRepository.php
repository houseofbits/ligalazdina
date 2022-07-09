<?php

namespace LigaLazdinaPortfolio\Services;

use Exception;
use LigaLazdinaPortfolio\Helpers\Console;
use LigaLazdinaPortfolio\Structures\ItemStructure;
use mysqli;

class ProductFeedRepository
{
    private const TABLE_NAME = 'product_feed';

    private ?mysqli $mysqlConnection = null;

    public function __construct()
    {
        $host = $_ENV['MYSQL_HOST'];
        $user = $_ENV['MYSQL_USER'];
        $pass = $_ENV['MYSQL_PASSWORD'];

        $this->mysqlConnection = mysqli_connect($host, $user, $pass, $_ENV['MYSQL_DATABASE']);

        if (!$this->mysqlConnection) {
            Console::printLn("Failed to connect to DB", 'e');
        }
    }

    /**
     * @throws Exception
     */
    public function persistItem(ItemStructure $item, bool $silent = false): void
    {
        $existingProduct = $this->query("SELECT * FROM {table-name} WHERE variantId='{variantId}'", ['variantId' => $item->variantId]);

        $result = $existingProduct->num_rows > 0
            ? $this->update($item)
            : $this->insert($item);

        if (!$result) {
            throw new Exception(mysqli_error($this->mysqlConnection));
        }
    }

    public function createSchema(): void
    {
        if (!$this->query("DESCRIBE {table-name}")) {
            $result = $this->query("
            CREATE TABLE {table-name}
            (
                `id`        INT(11)      NOT NULL AUTO_INCREMENT,
                `itemId`    VARCHAR(100) NOT NULL,
                `variantId` VARCHAR(100) NOT NULL,
                `url`       VARCHAR(100) NOT NULL,
                `imageUrl`  VARCHAR(100) NOT NULL,
                `title`     VARCHAR(500) NOT NULL,
                `description` VARCHAR(2000) NOT NULL,
                `price`     VARCHAR(100) NOT NULL,
                `color`     VARCHAR(100) NULL,
                `size`      VARCHAR(100) NULL,
                `ageGroup`      VARCHAR(100) NULL,
                `gender`      VARCHAR(100) NULL,
                `isEnabled`      VARCHAR(100) NULL,
                `googleProductCategory`      VARCHAR(100) NOT NULL,
                
                PRIMARY KEY (`id`)
            );");

            $result
                ? Console::printLn("Schema created", 's')
                : Console::printLn("Failed to create schema. " . mysqli_error($this->mysqlConnection), 'e');

        } else {
            Console::printLn("Schema exists");
        }
    }

    public function dropSchema(): void
    {
        if ($this->query("DESCRIBE {table-name}")) {
            $result = $this->query("DROP TABLE {table-name}");

            $result
                ? Console::printLn("Schema droppeed", 's')
                : Console::printLn("Failed to drop schema. " . mysqli_error($this->mysqlConnection), 'e');
        }
    }

    /**
     * @param string|null $itemId
     * @return ItemStructure[]
     */
    public function listProducts(?string $itemId = null): array
    {
        if ($itemId !== null) {
            $result = $this->query("SELECT * FROM {table-name} WHERE itemId='{itemId}'", ['itemId' => $itemId]);
        } else {
            $result = $this->query("SELECT * FROM {table-name}");
        }

        if ($result->num_rows > 0) {
            $products = [];
            while ($product = $result->fetch_object(ItemStructure::class)) {
                $products[] = $product;
            }
            return $products;
        }

        return [];
    }

    private function query(string $query, array $params = [])
    {
        if ($this->mysqlConnection) {

            $keys = array_map(function (string $value) {
                return "{" . $value . "}";
            }, array_keys($params));

            $values = array_values($params);

            $keys[] = '{table-name}';
            $values[] = self::TABLE_NAME;

            $query = str_replace($keys, $values, $query);

            return mysqli_query($this->mysqlConnection, $query);
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function transaction(callable $method): void
    {
        if ($this->mysqlConnection) {

            mysqli_begin_transaction($this->mysqlConnection);

            try {
                $method();
                mysqli_commit($this->mysqlConnection);
            } catch (Exception $exception) {
                mysqli_rollback($this->mysqlConnection);
                throw $exception;
            }
        }
    }

    public function insert(ItemStructure $item): bool
    {
        $cols = (array)$item;
        $keys = array_keys($cols);

        $sql = "INSERT INTO " . self::TABLE_NAME . " 
        (" . implode(',', $keys) . ") 
        VALUES (" . implode(',', array_fill(0, count($keys), '?')) . ")";

        $stmt = mysqli_prepare($this->mysqlConnection, $sql);
        mysqli_stmt_bind_param($stmt, str_repeat('s', count($keys)), ...array_values($cols));

        return mysqli_stmt_execute($stmt);
    }

    private function update(ItemStructure $item): bool
    {
        $cols = (array)$item;
        $keys = array_keys($cols);

        $values = array_map(function ($key) {
            return $key . "=?";
        }, $keys);

        $sql = "UPDATE " . self::TABLE_NAME . " SET " . implode(', ', $values) . " WHERE variantId='" . $item->variantId . "'";

        $stmt = mysqli_prepare($this->mysqlConnection, $sql);
        mysqli_stmt_bind_param($stmt, str_repeat('s', count($keys)), ...array_values($cols));

        return mysqli_stmt_execute($stmt);
    }

}