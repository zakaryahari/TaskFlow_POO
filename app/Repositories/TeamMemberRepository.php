<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;
use Exception;

class TeamMemberRepository extends BaseRepository {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM team_members WHERE id = :id";
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
            $sql = "SELECT * FROM team_members";
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
            $sql = "INSERT INTO team_members (username, email, password_hash, role, team_id) 
                    VALUES (:username, :email, :password, :role, :team_id)";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":username", $data['username']);
            $query->bindValue(":email", $data['email']);
            $query->bindValue(":password", $data['password_hash']);
            $query->bindValue(":role", $data['role']);
            $query->bindValue(":team_id", $data['team_id'], PDO::PARAM_INT);
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
            $sql = "DELETE FROM team_members WHERE id = :id";
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