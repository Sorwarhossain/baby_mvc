<?php

class m0002_add_password_column {
    public function up()
    {
        $app = new App\Core\Application(__DIR__);
        $db = $app->database;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL");
    }

    public function down()
    {
        $app = new App\Core\Application(__DIR__);
        $db = $app->database;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL");
    }
}