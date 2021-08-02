<?php

namespace EcJobHunting\Admin;

use EcJobHunting\Admin\Registry\AcfFields;
use EcJobHunting\Admin\Registry\CustomPostTypes;
use EcJobHunting\Admin\Registry\CustomTaxonomies;
use EcJobHunting\Admin\Registry\ThemeSettings;

class AdminInit
{
    public static function init()
    {
        $acf = new AcfFields();
        $cpt = new CustomPostTypes();
        $taxonomies = new CustomTaxonomies();
        $options = new ThemeSettings();
    }
}
