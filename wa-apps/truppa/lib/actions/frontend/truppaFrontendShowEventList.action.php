<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 10.12.2017
 * Time: 23:09
 */

class truppaFrontendShowEventListAction extends truppaFrontendDefaultAction
{
    public function execute()
    {
        $model = new truppaEventModel();
        //TODO переделать на коллекцию
        $events = $model->getAll();

        $this->view->assign('events', $events);
    }
}