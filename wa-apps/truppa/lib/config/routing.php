<?php
return array (
    'ajax' => 'frontend/json',
    'event/add' => 'frontend/addEvent',
    'event/list' => 'frontend/showEventList',
    'event/view/<url>' => 'frontend/viewEvent',
    '*' => 'frontend/default',
);
