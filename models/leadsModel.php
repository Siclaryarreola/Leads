<?php
class LeadModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Obtener todos los leads, con filtros opcionales
    public function getLeads($filters = []) {
        $query = "SELECT * FROM leads";
        $params = [];
        
        // Agregar filtros de búsqueda si están presentes
        if (!empty($filters)) {
            $query .= " WHERE ";
            foreach ($filters as $field => $value) {
                $query .= "$field = ? AND ";
                $params[] = $value;
            }
            $query = rtrim($query, "AND ");
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Agregar un nuevo lead
    public function addLead($data) {
        $stmt = $this->db->prepare("
            INSERT INTO leads (usuario_id, empresa, localidad, giro, estado, contacto, telefono, correo, fecha_prospeccion, cotizacion, notas, archivo, estatus) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute(array_values($data));
    }
}
