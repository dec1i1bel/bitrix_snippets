<?php

namespace Sprint\Migration;

use Bitrix\Main\Application;
use Bitrix\Main\DB\SqlQueryException;
use Demo\Orm\RandomDiscountTable;

class CreateTableRandomDiscount_20230211091728 extends Version
{
    protected $description = "Создаёт таблицу для компонента random.discount";

    protected $moduleVersion = "4.2.4";

    /**
     * @throws SqlQueryException
     */
    public function up()
    {
        $tableName = RandomDiscountTable::getTableName();

        $connection = Application::getInstance()->getConnection();

        $connection->startTransaction();

        if (!empty($tableName) && !($connection->isTableExists($tableName))) {
            $connection->query(self::createTable($tableName));
        }

        $connection->commitTransaction();
    }

    /**
     * @throws SqlQueryException
     */
    public function down()
    {
        $tableName = RandomDiscountTable::getTableName();

        $connection = Application::getInstance()->getConnection();

        $connection->startTransaction();

        if (!empty($tableName) && !($connection->isTableExists($tableName))) {
            $connection->dropTable($tableName);
        }

        $connection->commitTransaction();
    }

    /**
     * @param $tableName
     * @return string - текст SQL-запроса
     */
    private static function createTable($tableName): string
    {
        return "CREATE TABLE ".$tableName. "(
            ID INT(11) UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
            USER_ID INT(11) NOT NULL,
            END_TIMESTAMP INT(15) NOT NULL,
            PROMOCODE VARCHAR(10) NOT NULL,
            PERCENTAGE INT(2) NOT NULL
        )";
    }
}
