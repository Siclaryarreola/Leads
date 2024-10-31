<?php
require_once('../../models/LeadModel.php');
require_once('../../models/UserModel.php');

class LeadsController {

    private $leadModel;

    public function __construct() {
        $this->leadModel = new LeadModel();
    }

    // Método para listar todos los leads con filtros
    public function index() {
        // Obtener filtros desde la solicitud
        $filters = [];
        if (isset($_GET['estado'])) $filters['estado'] = $_GET['estado'];
        if (isset($_GET['giro'])) $filters['giro'] = $_GET['giro'];
        if (isset($_GET['estatus'])) $filters['estatus'] = $_GET['estatus'];
        if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin'])) {
            $filters['fecha_prospeccion'] = [$_GET['fecha_inicio'], $_GET['fecha_fin']];
        }
        
        // Obtener leads filtrados desde el modelo
        $leads = $this->leadModel->getLeads($filters);
        
        // Pasar datos a la vista
        include('../../views/leads/leads.php');
    }

    // Método para agregar un nuevo lead
    public function addLead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Datos del formulario
            $data = [
                'usuario_id' => $_SESSION['user']['id'],
                'empresa' => $_POST['empresa'],
                'localidad' => $_POST['localidad'],
                'giro' => $_POST['giro'],
                'estado' => $_POST['estado'],
                'contacto' => $_POST['contacto'],
                'telefono' => $_POST['telefono'],
                'correo' => $_POST['correo'],
                'fecha_prospeccion' => $_POST['fecha_prospeccion'],
                'cotizacion' => $_POST['cotizacion'],
                'notas' => $_POST['notas'],
                'archivo' => $this->uploadFile($_FILES['archivo']),  // Manejar subida de archivo
                'estatus' => $_POST['estatus']
            ];

            // Guardar lead en la base de datos
            $this->leadModel->addLead($data);
            header('Location: index.php?controller=leads&action=index');
            exit();
        }
        // Mostrar formulario de agregar lead
        include('../../views/leads/addLead.php');
    }

    // Método para ver el detalle de un lead
    public function viewLead() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $lead = $this->leadModel->getLeadById($id);
            include('../../views/leads/viewLead.php');
        } else {
            echo "Error: Lead no encontrado.";
        }
    }

    // Método para editar un lead existente
    public function editLead() {
        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'empresa' => $_POST['empresa'],
                'localidad' => $_POST['localidad'],
                'giro' => $_POST['giro'],
                'estado' => $_POST['estado'],
                'contacto' => $_POST['contacto'],
                'telefono' => $_POST['telefono'],
                'correo' => $_POST['correo'],
                'fecha_prospeccion' => $_POST['fecha_prospeccion'],
                'cotizacion' => $_POST['cotizacion'],
                'notas' => $_POST['notas'],
                'archivo' => $this->uploadFile($_FILES['archivo'], $id),  // Manejar subida de archivo
                'estatus' => $_POST['estatus']
            ];

            // Actualizar lead en la base de datos
            $this->leadModel->updateLead($id, $data);
            header('Location: index.php?controller=leads&action=index');
            exit();
        }

        if ($id) {
            $lead = $this->leadModel->getLeadById($id);
            include('../../views/leads/editLead.php');
        } else {
            echo "Error: Lead no encontrado.";
        }
    }

    // Método para eliminar un lead
    public function deleteLead() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->leadModel->deleteLead($id);
            header('Location: index.php?controller=leads&action=index');
            exit();
        } else {
            echo "Error: Lead no encontrado.";
        }
    }

    // Método auxiliar para subir archivo
    private function uploadFile($file, $leadId = null) {
        if ($file['error'] == 0) {
            $destination = "../../uploads/" . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $destination;
            }
        }
        return null;
    }
}
