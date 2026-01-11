<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;
use Exception;

class ProjectRepository extends BaseRepository {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM projects WHERE id = :id";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $this->db->getConnection()->commit();
            return $result ?: null;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return null;
        }
    }

    public function findAll(): ?array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM projects";
            $query = $this->db->getConnection()->query($sql);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->db->getConnection()->commit();
            return $results;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return null;
        }
    }

    public function save(array $data): bool {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "INSERT INTO projects (name, description, team_id, status) VALUES (:name, :description, :team_id, :status)";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":name", $data['name']);
            $query->bindValue(":description", $data['description']);
            $query->bindValue(":team_id", $data['team_id'], PDO::PARAM_INT);
            $query->bindValue(":status", $data['status']);
            $query->execute();
            $this->db->getConnection()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return false;
        }
    }

    public function delete(int $id): bool {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "DELETE FROM projects WHERE id = :id";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":id", $id, PDO::PARAM_INT);
            $query->execute();
            $this->db->getConnection()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return false;
        }
    }
}