<?php

namespace Aditya\DetikTest\Controllers;

use Aditya\DetikTest\Models\Ticket;

class TicketController extends Controller
{
    private $requestMethod;
    private $ticketID;
    private $ticketCode;

    private $ticketModel;

    public function __construct($db, $requestMethod, $ticketID, $ticketCode)
    {
        $this->requestMethod = $requestMethod;
        $this->ticketID = $ticketID;
        $this->ticketCode = $ticketCode;
        $this->ticketModel = new Ticket($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                
                if ($this->ticketCode != null) {
                    $response = $this->findByCode($this->ticketCode);
                } else {
                    $response = $this->badRequestResponse('Kode tiket harus diisi!');
                }
                break;
            
            case 'PUT':
                $response = $this->updateTicketStatus($this->ticketCode);
                break;
            
            default:
                $response = $this->notFoundResponse('method not supported');
                break;
        }
        header($response['status_code_header']);
        echo $response['body'];
    }

    public function findByCode($code)
    {
        $result = $this->ticketModel->getByCode($code);
        if (!$result) {
            return $this->notFoundResponse('Tiket tidak ditemukan');
        }
        $data = [
            "ticket_code" => $result['code'],
            "status" => $result['status']
        ];
        return $this->okResponse('Tiket ditemukan', $data);
    }

    public function updateTicketStatus($code)
    {
        
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        $validation = $this->validate($input);
        if (!$validation['status']) {
            return $this->badRequestResponse($validation['message']);
        }

        $result = $this->ticketModel->getByCode($code);
        if (!$result) {
            return $this->notFoundResponse('Tiket tidak ditemukan');
        }

        if ($this->ticketModel->updateStatus($result['code'], ["status" => $input['status']]) > 0) {
            $result = $this->ticketModel->getByCode($code);
            $data = [
                'ticket_code' => $result['code'],
                'status' => $result['status'],
                'updated_at' => $result['updated_at'] 
            ];
            return $this->okResponse('Status tiket berhasil diperbarui', $data);
        }

        return $this->unprocessableEntityResponse('terjadi kesalahan saat mengupdate status tiket');
    }

    private function validate($input)
    {
        $status = isset($input['status']) ? $input['status'] : null;
        if ($status == null) {
            return [
                "status" => false,
                "message" => "status tidak boleh kosong!"
            ];
        }
        
        if ($status == 'available' || $status == 'claimed') {
            return [
                "status" => true
            ];
        }
        
        return [
            "status" => false,
            "message" => "status hanya boleh 'available' dan 'claimed' !"
        ];
    }
}
