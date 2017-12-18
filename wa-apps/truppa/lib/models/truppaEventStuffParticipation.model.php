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

    public function getParticipationContacts($event_id)
    {
        $stuff_model = new truppaEventStuffModel();
        $ids = $stuff_model->select('id')->where('event_id = '.$event_id)->fetchAll();
        foreach ($ids as $id) {
            $ids_ar[] = $id['id'];
        }
        if (count($ids_ar)) {
            $result = $this->select("*")->where('stuff_id IN ('.implode(',', $ids_ar).')')->fetchAll();
        } else {
            $result = array();
        }
        return $result;
    }
}