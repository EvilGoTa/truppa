<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.12.2017
 * Time: 23:09
 */

class truppaEventStuffParticipationModel extends waModel
{
    protected $table = 'truppa_event_stuff_participation';
    protected $id = 'stuff_id';
    protected $stuff_model;

    public function __construct($type = null, $writable = false)
    {
        parent::__construct($type, $writable);
        $this->stuff_model = new truppaEventStuffModel();
    }

    public function getParticipation($event_id, $contact_id)
    {
        return $this->getParticipationContacts($event_id, $contact_id);
    }

    public function getParticipationContacts($event_id, $contact_id = null)
    {
        $ids = $this->stuff_model->select('id')->where('event_id = '.$event_id)->fetchAll();
        foreach ($ids as $id) {
            $ids_ar[] = $id['id'];
        }
        if (count($ids_ar)) {
            $where = '';
            if ($contact_id) {
                $where = 'AND contact_id = '.$contact_id;
            }
            $result = $this->query("SELECT a.*, b.name FROM {$this->table} a JOIN {$this->stuff_model->getTableName()} b ON b.id = a.stuff_id WHERE stuff_id IN (".implode(',', $ids_ar).") $where")->fetchAll();
        } else {
            $result = array();
        }
        return $result;
    }
}