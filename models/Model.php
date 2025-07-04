<?php
abstract class Model
{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $mysqli, int $id)
    {
        $sql = sprintf(
            "Select * from %s WHERE %s = ?",
            static::$table,
            static::$primary_key
        );

        $query = $mysqli->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    public static function all(mysqli $mysqli)
    {
        $sql = sprintf("Select * from %s", static::$table);

        $query = $mysqli->prepare($sql);
        $query->execute();

        $data = $query->get_result();

        $objects = [];
        while ($row = $data->fetch_assoc()) {
            $objects[] = new static($row); //creating an object of type "static" / "parent" and adding the object to the array
        }

        return $objects; //we are returning an array of objects!!!!!!!!
    }

    //you have to continue with the same mindset
    //Find a solution for sending the $mysqli everytime... 
    //Implement the following: 
    //1- update() -> non-static function 
    //2- create() -> static function
    //3- delete() -> static function 

    public static function create(mysqli $mysqli, array $data)
    {
        $fields = array_keys($data);
        $placeholders = implode(", ", array_fill(0, count($fields), '?'));
        $columns = implode(", ", $fields);
        $types = str_repeat('s', count($fields)); // assumes all strings; adjust as needed
        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)", static::$table, $columns, $placeholders);
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param($types, ...array_values($data));
        $stmt->execute();
        $id = $stmt->insert_id;
        return static::find($mysqli, $id);
    }

    public static function update(mysqli $mysqli, int $id, array $data)
    {
        $fields = array_keys($data);
        $set = implode(", ", array_map(fn($f) => "$f = ?", $fields));
        $types = str_repeat('s', count($fields)) . 'i'; // all fields as string, id as int
        $sql = sprintf("UPDATE %s SET %s WHERE %s = ?", static::$table, $set, static::$primary_key);
        $stmt = $mysqli->prepare($sql);
        $values = array_values($data);
        $values[] = $id;
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        return static::find($mysqli, $id);
    }

    public static function delete(mysqli $mysqli, int $id)
    {
        $sql = sprintf("DELETE FROM %s WHERE %s = ?", static::$table, static::$primary_key);
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $result = $stmt->execute();
        return $result;
    }

    public static function deleteAll(mysqli $mysqli)
    {
        $sql = sprintf("DELETE FROM %s", static::$table);
        $stmt = $mysqli->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }
}
