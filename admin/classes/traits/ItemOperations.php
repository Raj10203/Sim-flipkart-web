<?php
namespace Admin\Classes\Traits;

trait ItemOperations
{
    public function deleteItem($tableName, $id)
    {
        $query = "DELETE FROM " . $tableName . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $result =  $stmt->execute();
        return $result;
    }

    public function getItemById ($tableName, $id) {
        $query = "SELECT * FROM " . $tableName . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_assoc();
        return $items;
    }
    public function getAllItems($table)
    {
        $query = "SELECT * FROM " . $table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
}
