<?php

namespace EcJobHunting\Service\Widget;

class WidgetInit
{
    public function __invoke()
    {
        $this->widgetsArea();
    }

    private function widgetsArea(){
        register_sidebar(
            [
                'name' => 'Footer Fullwidth',
                'id' => 'footer-fullwidth',
                'before_widget' => '<div class="col-12 col-xl-9">',
                'after_widget' => '</div>',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
            ]
        );
        register_sidebar(
            [
                'name' => 'Footer Columns',
                'id' => 'footer-columns',
                'before_widget' => '<div class="col-12 col-md-4 col-xl-3">',
                'after_widget' => '</div>',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
            ]
        );
    }
}