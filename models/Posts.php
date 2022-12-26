<?php
class Posts
{
    private $conn;

    public $id;
    public $title;
    public $author;
    public $body;
    public $category_name;
    public $category_id;
    public $created_at;

    function __construct($db)
    {
        $this->conn = $db;
    }

    function read()
    {
        $query = "SELECT * FROM posts as p LEFT JOIN categories as c ON p.category_id = c.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function read_single()
    {
        $query = "SELECT * FROM posts as p LEFT JOIN categories as c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->title = $row['title'];
        $this->author = $row['author'];
        $this->body = html_entity_decode($row['body']);
        $this->category_name = $row['name'];
        $this->category_id = $row['category_id'];
    }

    function create()
    {
        $query = "INSERT INTO posts SET title = :title, author = :author, body = :body, category_id = :category_id";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":body", $this->body);
        $stmt->bindParam(":category_id", $this->category_id);

        if ($stmt->execute()) {
            return true;
        }

        echo "Error: $stmt->error";
        return false;
    }

    function update()
    {
        $query = "UPDATE posts SET title = :title, author = :author, body = :body, category_id = :category_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":body", $this->body);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        echo "Error: $stmt->error";
        return false;
    }

    function delete()
    {
        $query = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        echo "Error: $stmt->error";
        return false;
    }
}
