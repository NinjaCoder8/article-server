<?php
require_once("Model.php");

class category extends Model
{

    private int $id;

    protected static string $table = "categories";

    public function __construct(array $data)
    {
        $this->id = $data["id"];
    }

    public function toArray()
    {
        return [$this->id];
    }

    public static function findByArticle(mysqli $mysqli, int $article_id)
    {
        $sql = "SELECT c.* FROM categories c JOIN articles a ON c.id = a.category_id WHERE a.id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $article_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? new static($row) : null;
    }
}
