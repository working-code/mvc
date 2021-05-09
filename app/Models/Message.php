<?php

namespace App\Models;

use App\Core\MainModel;
use PDO;

class Message extends MainModel
{
    private $message;
    private $date;
    private $id;
    private $imgSrc;
    private $userId;

    public function __construct($data = [])
    {
        if ($data) {
            $this->message = $data['message'];
            $this->date = $data['date'];
            $this->id = $data['id'];
            $this->imgSrc = $data['img'] ?? '';
            $this->userId = $data['user_id'];
        }
    }

    public function save()
    {
        $query = "INSERT INTO blog(`message`, `date`, `user_id`, `img`)
            VALUES(:message, :date, :user_id, :img)";
        $sth = $this->getDb()->prepare($query);
        if ($sth->execute([
            'message' => $this->getMessage(),
            'date' => $this->getDate(),
            'user_id' => $this->getUserId(),
            'img' => $this->getImgSrc()
        ])) {
            return true;
        }
        return false;
    }

    public function getMessages(int $countMessage = 20): array
    {
        $query = "SELECT blog.id, blog.message, blog.date, blog.img, users.name 
            FROM blog LEFT OUTER JOIN users
            ON blog.user_id = users.id
            LIMIT $countMessage;";
        $sth = $this->getDb()->prepare($query);
        if ($sth->execute()) {
            return $message = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getMessagesForUserId(int $userId, int $countMessage = 20): array
    {
        $query = "SELECT blog.message, blog.date
            FROM blog LEFT OUTER JOIN users
            ON blog.user_id = users.id
            WHERE users.id = $userId
            LIMIT $countMessage;";
        $sth = $this->getDb()->prepare($query);
        if ($sth->execute()) {
            return $message = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function deleteMessageForId(int $id): bool
    {
        $query = "DELETE FROM blog WHERE id = $id";
        $sth = $this->getDb()->prepare($query);
        return $sth->execute();
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getImgSrc(): ?string
    {
        return $this->imgSrc;
    }

    public function setImgSrc(string $imgSrc): self
    {
        $this->imgSrc = $imgSrc;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
}
