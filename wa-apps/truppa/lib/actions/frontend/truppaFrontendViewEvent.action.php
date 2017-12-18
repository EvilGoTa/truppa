<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.11.2017
 * Time: 23:40
 */

class truppaFrontendViewEventAction extends truppaFrontendDefaultAction
{
    public function execute()
    {
        $url = waRequest::param('url');
        $event = new truppaEvent($url);

        $this->view->assign('event', $event);
    }
}