<?php
class truppaFrontendAction extends waViewAction
{
    public function preExecute()
    {
        wa('site');
        $theme = new waTheme(waRequest::getTheme());
        $this->view->assign('wa_theme_url', $theme->getUrl() );
        $this->setLayout(new siteFrontendLayout());
    }

    public function execute()
    {

    }
}
