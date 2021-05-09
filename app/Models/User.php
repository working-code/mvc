<?php

namespace App\Models;

use App\Core\Db;
use App\Core\MainModel;
use PDO;

class User extends MainModel
{
    private string $name;
    private int $id;
    private string $dateRegistration;
    private string $email;
    private string $password;

    public function __construct($dataUser = [])
    {
        if ($dataUser) {
            $this->name = $dataUser['name'];
            $this->dateRegistration = $dataUser['date_registration'];
            $this->email = $dataUser['email'];
            $this->password = $dataUser['password'];
            $this->id = $dataUser['id'];
        }
    }

    public function save(): bool
    {
        $query = "INSERT INTO users(`name`, `date_registration`, `email`, `password`) 
        VALUES(:name, :date_registration, :email, :password)";
        $sth = $this->getDb()->prepare($query);
        if ($sth->execute([
            'name' => $this->name,
            'date_registration' => $this->dateRegistration,
            'email' => $this->email,
            'password' => $this->password
        ])) {
            $this->getByEmail($this->email);
            return true;
        }
        return false;
    }

    public function getById(int $id): ?self
    {
        $query = "SELECT * FROM users WHERE id = $id LIMIT 1";
        $sth = $this->getDb()->prepare($query);
        if ($sth->execute()) {
            $data = $sth->fetch();
            if ($data) {
                return $this
                    ->setId($data['id'])
                    ->setName($data['name'])
                    ->setEmail($data['email'])
                    ->setPassword($data['password'])
                    ->setDateRegistration($data['date_registration']);
            }
        }
        return null;
    }

    public function getByEmail(string $email): ?self
    {
        $query = "SELECT * FROM users WHERE `email` = :email LIMIT 1";
        $sth = $this->getDb()->prepare($query);
        if ($sth->execute(['email' => $email])) {
            $data = $sth->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                return $this
                    ->setId($data['id'])
                    ->setName($data['name'])
                    ->setEmail($data['email'])
                    ->setPassword($data['password'])
                    ->setDateRegistration($data['date_registration']);
            }
        }
        return null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getDateRegistration(): string
    {
        return $this->dateRegistration;
    }

    public function setDateRegistration($dateRegistration): self
    {
        $this->dateRegistration = $dateRegistration;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }
}
