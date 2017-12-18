<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 06.11.2017
 * Time: 18:31
 */

class truppaFrontendDefaultAction extends truppaFrontendAction
{
    public function execute()
    {
        $this->redirect('/event/list');
    }
}