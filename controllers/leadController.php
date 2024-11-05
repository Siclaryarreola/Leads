<?php
require_once('../../models/leadsModel.php');

class LeadsController {

    private $leadModel;

    public function __construct() {
        $this->leadModel = new LeadModel();
    }

    public function index() {
        $filters = [];
        if ($_SESSION['user']['rol'] == 0) {
            $filters['usuario_id'] = $_SESSION['user']['id'];
        }
        return $this->leadModel->getLeads($filters);
    }

    public function addLead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                'archivo' => $this->uploadFile($_FILES['archivo']),
                'estatus' => $_POST['estatus']
            ];
            $this->leadModel->addLead($data);
            header('Location: index.php?controller=leads&action=index');
            exit();
        }
    }

    private function uploadFile($file) {
        if ($file['error'] == 0) {
            $destination = "../../uploads/" . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $destination;
            }
        }
        return null;
    }
}
?>