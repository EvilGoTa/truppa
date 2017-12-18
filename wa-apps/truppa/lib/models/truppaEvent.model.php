<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 23:04
 */

class truppaEventModel extends waModel
{
    protected $table = 'truppa_event';

    public function addStuff($data)
    {
        $model = new truppaEventStuffModel();
        $model->insert($data, true);
    }
}