<?php
require_once(__DIR__ . '/../config/database.php');

class LeadModel {
    private $db;

    public function __construct() {
        // Obtener la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener leads junto con la información del cliente
    public function getLeads($filters = []) {
        // Consulta que une leads con clientesleads
        $query = "
            SELECT leads.*, clientesleads.contacto, clientesleads.correo, clientesleads.telefono, clientesleads.empresa,
                   clientesleads.giro, clientesleads.localidad, clientesleads.sucursal
            FROM leads
            LEFT JOIN clientesleads ON leads.id_cliente = clientesleads.id_clienteLead
        ";
        
        $params = [];
        $conditions = [];
    
        // Agregar filtro por ID de usuario, si se proporciona
        if (!empty($filters['id_usuario'])) {
            $conditions[] = "leads.id_usuario = ?";
            $params[] = $filters['id_usuario'];
        }
    
        // Agregar condiciones a la consulta si hay filtros
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        // Ordenar resultados por fecha de prospección de forma descendente
        $query .= " ORDER BY leads.fecha_generacion DESC";
    
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            // Vincular parámetros si existen
            if (!empty($params)) {
                $stmt->bind_param(str_repeat('s', count($params)), ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Método para obtener un lead específico por su ID
    public function getLeadById($id) {
        // Consulta para obtener un lead específico
        $query = "
            SELECT leads.*, clientesleads.contacto, clientesleads.correo, clientesleads.telefono, clientesleads.empresa,
                   clientesleads.giro, clientesleads.localidad, clientesleads.sucursal
            FROM leads
            LEFT JOIN clientesleads ON leads.id_cliente = clientesleads.id_clienteLead
            WHERE leads.id_leads = ?
        ";
        
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }
}
?>
