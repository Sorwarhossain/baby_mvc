<?php

namespace App\Core;

abstract class DBModel extends Model
{
    abstract public function tableName();
    abstract public function attributes(): array;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (". implode(',', $attributes) .") VALUES(". implode(",", $params) .")");

        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        return $statement->execute();
    }

    public static function prepare($sql)
    {
        return Application::$app->database->prepare($sql);
    }
}