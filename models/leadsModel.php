<?php
require_once('../../config/database.php');

class LeadModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getLeads($filters = []) {
        $query = "SELECT * FROM leads";
        $params = [];
        $conditions = [];

        if (!empty($filters['usuario_id'])) {
            $conditions[] = "usuario_id = ?";
            $params[] = $filters['usuario_id'];
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function addLead($data) {
        $stmt = $this->db->prepare("
            INSERT INTO leads (usuario_id, empresa, localidad, giro, estado, contacto, telefono, correo, fecha_prospeccion, cotizacion, notas, archivo, estatus) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        if ($stmt) {
            return $stmt->execute(array_values($data));
        }
        return false;
    }
}