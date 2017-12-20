<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 07.12.2017
 * Time: 0:21
 */

class truppaEventStuffModel extends waModel
{
    protected $table = 'truppa_event_stuff';

    public function getPaticipation($event_id)
    {
        $participation = new truppaEventStuffParticipationModel();
        return $this->query("SELECT p.* FROM {$participation->getTableName()} p 
          JOIN {$this->table} s ON s.id = p.stuff_id WHERE s.event_id = {$event_id}")->fetchAll();
    }
}