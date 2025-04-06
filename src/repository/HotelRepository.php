<?php

namespace App\repository;

use PDO;

class HotelRepository
{
    public function __construct(private readonly PDO $conn) { }

    public function getAllHotels(): array
    {
        return $this->conn->query('SELECT id, name FROM hotels')->fetchAll(PDO::FETCH_ASSOC);
    }
}
