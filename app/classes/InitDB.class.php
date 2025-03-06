<?php

// auto create database tables
class InitDB extends Dbhandler {
    // Метод для создания таблиц
    private function CreateNeededTables() {
        // Проверяем существование таблиц и создаём их, если они не существуют
        $tables = array();

        // members table
        if (!$this->tableExists('members')) {
            array_push(
                $tables, "CREATE TABLE members(
                    MemberID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    Username VARCHAR(64) NOT NULL,
                    Password VARCHAR(512) NOT NULL,
                    Email VARCHAR(64) NOT NULL,
                    PrivilegeLevel INT NOT NULL DEFAULT 0,
                    Attempt INT NOT NULL,
                    RegisteredDate DATE
                )"
            );
        }

        // Orders table
        if (!$this->tableExists('orders')) {
            array_push(
                $tables, "CREATE TABLE orders(
                    OrderID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    MemberID INT NOT NULL,
                    CONSTRAINT fk_Orders_members FOREIGN KEY (MemberID) REFERENCES members(MemberID),
                    CartFlag BIT NOT NULL DEFAULT 1
                )"
            );
        }

        // Payment table
        if (!$this->tableExists('payment')) {
            array_push(
                $tables, "CREATE TABLE payment(
                    PaymentID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    OrderID INT NOT NULL,
                    CONSTRAINT fk_Payment_Orders FOREIGN KEY (OrderID) REFERENCES orders(OrderID),
                    PaymentDate DATE NOT NULL
                )"
            );
        }

        // Items table
        if (!$this->tableExists('items')) {
            array_push(
                $tables, "CREATE TABLE items(
                    ItemID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    Name VARCHAR(64) NOT NULL,
                    Brand VARCHAR(64) NOT NULL,
                    Description VARCHAR(512) NOT NULL,
                    Category INT NOT NULL,
                    SellingPrice FLOAT NOT NULL,
                    QuantityInStock INT NOT NULL,
                    Image VARCHAR(512) NOT NULL
                )"
            );
        }

        // OrderItems table
        if (!$this->tableExists('orderitems')) {
            array_push(
                $tables, "CREATE TABLE orderitems(
                    OrderItemID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
                    OrderID INT NOT NULL,
                    ItemID INT NOT NULL,
                    CONSTRAINT fk_OrderItems_Orders FOREIGN KEY (OrderID) REFERENCES orders(OrderID),
                    CONSTRAINT fk_OrderItems_Items FOREIGN KEY (ItemID) REFERENCES items(ItemID),
                    Price FLOAT NOT NULL,
                    Quantity INT NOT NULL,
                    AddedDatetime DATETIME NOT NULL,
                    Feedback VARCHAR(512),
                    Rating INT,
                    RatingDateTime DATETIME
                )"
            );
        }

        // Выполняем запросы на создание таблиц
        foreach ($tables as $table) {
            $this->conn()->query($table);
        }
    }

    // Метод для проверки существования таблицы
    private function tableExists($tableName) {
        $result = $this->conn()->query("SHOW TABLES LIKE '$tableName'");
        return $result->num_rows > 0;
    }

    // Публичный метод для вызова CreateNeededTables
    public function initDbExec() {
        $this->CreateNeededTables();
    }
}
