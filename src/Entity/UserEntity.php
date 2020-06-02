<?php

namespace Entity;

use Metrotel\Src\AbstractEntity;

class UserEntity extends AbstractEntity {
    protected $table = 'user';
    protected $primary_key = 'id';

    /**
     * @var int
     */
    protected $id = null;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $lastname;
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;

    protected $fields = [
        'id',
        'name',
        'lastname',
        'login',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }
}