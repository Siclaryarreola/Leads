<?php
require_once(__DIR__ . '/../models/leadsModel.php');
session_start(); // Iniciar sesión para acceder a los datos del usuario

class LeadsController {
    private $leadModel;

    public function __construct() {
        // Crear una instancia del modelo
        $this->leadModel = new LeadModel();
    }

    // Método para obtener la lista de leads
    public function index($filters = []) {
        // Obtener leads aplicando filtros opcionales
        $leads = $this->leadModel->getLeads($filters);

        // Obtener el rol del usuario desde la sesión
        $rolUsuario = $_SESSION['user']['rol'] ?? null;

        // Pasar los leads y el rol del usuario a la vista
        include(__DIR__ . '/../views/leads.php');
    }

    // Método para obtener los detalles de un lead específico
    public function getLeadDetails($id) {
        // Obtener detalles de un lead por su ID
        return $this->leadModel->getLeadById($id);
    }
}

// Procesar la solicitud AJAX para obtener los detalles de un lead
if (isset($_GET['action']) && $_GET['action'] === 'getLeadDetails' && isset($_GET['id'])) {
    $controller = new LeadsController();
    $leadDetails = $controller->getLeadDetails($_GET['id']);
    echo json_encode($leadDetails);
    exit;
}
?>
