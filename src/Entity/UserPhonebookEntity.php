<?php

namespace Entity;

use Metrotel\Src\AbstractEntity;

class UserPhonebookEntity extends AbstractEntity {
    protected $table = 'user_phonebook';
    protected $primary_key = 'id';

    /**
     * @var int
     */
    protected $id = null;
    /**
     * @var int
     */
    protected $user_id;
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
    protected $phone;
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $image;
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
        'user_id',
        'name',
        'lastname',
        'phone',
        'email',
        'image',
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

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
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

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setImage(string $image = null): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
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