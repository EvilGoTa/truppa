<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 10.12.2017
 * Time: 22:07
 */

class truppaFrontendJsonController extends waJsonController
{
    public function execute()
    {
        $action = waRequest::post('action', 'default');
        $actionName = $action."Action";
        if (method_exists($this, $actionName)) {
            $this->{$actionName}();
        }
    }

    public function checkFieldAction()
    {
        $field = waRequest::post('field');
        $value = waRequest::post('value');

        $fields = array(
            'name'
        );
        if (!in_array($field, $fields)) {
            $this->errors = 1;
            wa_dump(1);
            return;
        }
        // TODO escape this
//        $value = mysql_escape_string($value);

        $model = new truppaEventModel();
        try {
            $check = $model->select("$field")->where("$field = '$value'")->fetch();
        } catch (Exception $e) {
            wa_dump($e->getMessage());
            $this->errors = 1;
            return;
        }
        if (count($check)) {
            $this->response = array('check' => 'fail');
        } else {
            $this->response = array('check' => 'success');
        }
    }

    public function deleteParticipantAction()
    {
        $event_id = waRequest::post('event_id', 0);
        $contact_id = waRequest::post('contact_id', 0);
        $user_id = wa()->getUser()->getId();

        $eventModel = new truppaEventModel();
        $event = $eventModel->getByField([
            'id' => $event_id,
            'contact_id' => $user_id
        ]);
        if ($event) {
            $stuffModel = new truppaEventStuffModel();
            $stuff = $stuffModel->getPaticipation($event['id']);
            foreach ($stuff as $s) {
//                wa_dump($s, $contact_id);
                if ($s['contact_id'] == $contact_id) {
                    $participantModel = new truppaEventStuffParticipationModel();
                    $participantModel->deleteById($s['stuff_id']);
                }
            }
        } else {
            $this->errors = 1;
        }
    }
}