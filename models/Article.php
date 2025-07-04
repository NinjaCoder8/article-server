<?php
require_once("Model.php");

class Article extends Model
{

    private int $id;
    private string $name;
    private string $author;
    private string $description;

    protected static string $table = "articles";

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->author = $data["author"];
        $this->description = $data["description"];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setAuthor(string $author)
    {
        $this->author = $author;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function toArray()
    {
        return [$this->id, $this->name, $this->author, $this->description];
    }

    public static function findByCategory(mysqli $mysqli, int $category_id)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE category_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = new static($row);
        }
        return $articles;
    }
}
