<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;
use Exception;

class TaskRepository extends BaseRepository {
    private Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function find(int $id): ?array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM tasks WHERE id = :id";
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

    public function save(array $data): bool {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "INSERT INTO tasks (title, description, project_id, reporter_id, priority, status) 
                    VALUES (:title, :description, :project_id, :reporter_id, :priority, :status)";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":title", $data['title']);
            $query->bindValue(":description", $data['description']);
            $query->bindValue(":project_id", $data['project_id'], PDO::PARAM_INT);
            $query->bindValue(":reporter_id", $data['reporter_id'], PDO::PARAM_INT);
            $query->bindValue(":priority", $data['priority']);
            $query->bindValue(":status", $data['status']);
            $query->execute();
            $this->db->getConnection()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return false;
        }
    }

    public function findByAssignee(int $assigneeId): array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM tasks WHERE assignee_id = :id";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":id", $assigneeId, PDO::PARAM_INT);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->db->getConnection()->commit();
            return $results;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return [];
        }
    }

    public function findByProject(int $projectId): array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM tasks WHERE project_id = :id";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":id", $projectId, PDO::PARAM_INT);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->db->getConnection()->commit();
            return $results;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return [];
        }
    }

    public function findByStatus(string $status): array {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "SELECT * FROM tasks WHERE status = :status";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":status", $status);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->db->getConnection()->commit();
            return $results;
        } catch (Exception $e) {
            $this->db->getConnection()->rollBack();
            return [];
        }
    }

    public function assignTask(int $taskId, int $assigneeId): bool {
        try {
            $this->db->getConnection()->beginTransaction();
            $sql = "UPDATE tasks SET assignee_id = :assignee_id WHERE id = :id";
            $query = $this->db->getConnection()->prepare($sql);
            $query->bindValue(":assignee_id", $assigneeId, PDO::PARAM_INT);
            $query->bindValue(":id", $taskId, PDO::PARAM_INT);
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
            $sql = "DELETE FROM tasks WHERE id = :id";
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