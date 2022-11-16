<?php

namespace Aditya\DetikTest\Controllers;

use Aditya\DetikTest\Models\Event;

class EventController extends Controller
{  
    private $requestMethod;
    private $eventID;
    
    private $eventModel;

    public function __construct($db, $requestMethod, $eventID)
    {
        $this->requestMethod = $requestMethod;
        $this->eventID = $eventID;

        $this->eventModel = new Event($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->find($this->eventID);
                break;
            
            case 'POST':
                $response = $this->create();
                break;

            default:
                $response = $this->notFoundResponse('method not supported');
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }

    public function find($id)
    {
        $result = $this->eventModel->get($id);
        return $this->okResponse('Here is your Event Data', $result);
    }

    public function create()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        
        $validation = $this->validate($input);
        if (!$validation['status']) {
            return $this->badRequestResponse($validation['message']);
        }

        if($this->eventModel->save($input)){
            return $this->okResponse('Event berhasil dibuat');
        }
        return $this->unprocessableEntityResponse('Terjadi kesalahan saat membuat event');
    }

    private function validate($input)
    {
        $name = isset($input['name']) ? $input['name'] : null;
        if ($name == null) {
            return [
                "status" => false,
                "message" => "nama tidak boleh kosong!"
            ];
        }

        return [
            "status" => true,
        ];
    }
}
