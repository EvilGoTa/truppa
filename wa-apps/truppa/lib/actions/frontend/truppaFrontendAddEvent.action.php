<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 06.11.2017
 * Time: 18:38
 */

class truppaFrontendAddEventAction extends truppaFrontendAction
{

    protected $errors = array();

    public function execute() {
        if (waRequest::method() == 'post') {
            $data = waRequest::post('data', array());
//            wa_dump($data);
            $event = new truppaEvent($data);
            if ($event->isValid()) {
                $event->save();
                wa()->getResponse()->redirect(
                    wa()->getRouteUrl('truppa/frontend/showEventList')
                );
            } else {
                $errors = $event->getErrors();
            }
        }

        $categories = array();
        $category_model = new truppaEventCategoryModel();
        $categories = $category_model->getAll();
        $this->view->assign('categories', $categories);

        $cities = array();
        //TODO взять откуда-то города...
        $cities[] = array('id' => 1, 'name' => 'Москва');
        $this->view->assign('cities', $cities);


        $this->getResponse()->addCss('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
        $this->getResponse()->addCss('css/frontend/jquery.datetimepicker.min.css', 'truppa');
        $this->getResponse()->addCss('css/frontend/truppa.css', 'truppa');
        $this->getResponse()->addCss('css/wysibb/theme/default/wbbtheme.css', 'truppa');
        $this->getResponse()->addJs('https://code.jquery.com/ui/1.12.1/jquery-ui.js');
        $this->getResponse()->addJs('js/jquery.datetimepicker.full.min.js', 'truppa');
        $this->getResponse()->addJs('js/wysibb/jquery.wysibb.min.js', 'truppa');
        $this->getResponse()->addJs('js/frontend/addEvent.js', 'truppa');
    }

    private function checkData($data)
    {

    }
}