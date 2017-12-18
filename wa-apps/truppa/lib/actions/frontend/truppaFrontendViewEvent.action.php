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

        $this->view->assign('participation', $event->isParticipant(wa()->getUser()->getId()));

        if (waRequest::method() == 'post') {
            $contact_id = waRequest::post('participant', false);
            if ($contact_id) {
                $stuff = waRequest::post('stuff', array());
                foreach($stuff as $s_id => $s_count) {
                    if ($s_count > 0) {
                        $event->addStuff($s_id, $s_count, $contact_id);
                    }
                }
            }
        }

        $this->view->assign('event', $event);
    }
}