<?php
/*
Plugin Name: Gravity Forms Simple Add-On
Plugin URI: http://www.gravityforms.com
Description: A simple add-on to demonstrate the use of the Add-On Framework
Version: 1.1
Author: Rocketgenius
Author URI: http://www.rocketgenius.com

------------------------------------------------------------------------
Copyright 2012-2013 Rocketgenius Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


//------------------------------------------
if (class_exists("GFForms")) {
    GFForms::include_addon_framework();

    class GFSimpleAddOn extends GFAddOn {

        protected $_version = "1.1";
        protected $_min_gravityforms_version = "1.7.9999";
        protected $_slug = "simpleaddon";
        protected $_path = "asimpleaddon/asimpleaddon.php";
        protected $_full_path = __FILE__;
        protected $_title = "Gravity Forms Simple Add-On";
        protected $_short_title = "Simple Add-On";

        public function init(){
            parent::init();
            add_filter("gform_submit_button", array($this, "form_submit_button"), 10, 2);
        }

        // Add the text in the plugin settings to the bottom of the form if enabled for this form
        function form_submit_button($button, $form){
            $settings = $this->get_form_settings($form);
            if(isset($settings["enabled"]) && true == $settings["enabled"]){
                $text = $this->get_plugin_setting("mytextbox");
                $button = "<div>{$text}</div>" . $button;
            }
            return $button;
        }


        public function plugin_page() {
            ?>
            This page appears in the Forms menu
        <?php
        }

        public function form_settings_fields($form) {
            return array(
                array(
                    "title"  => "Simple Form Settings",
                    "fields" => array(
                        array(
                            "label"   => "My checkbox",
                            "type"    => "checkbox",
                            "name"    => "enabled",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "Enabled",
                                    "name"  => "enabled"
                                )
                            )
                        ),
                        array(
                            "label"   => "My checkboxes",
                            "type"    => "checkbox",
                            "name"    => "checkboxgroup",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice",
                                    "name"  => "first"
                                ),
                                array(
                                    "label" => "Second Choice",
                                    "name"  => "second"
                                ),
                                array(
                                    "label" => "Third Choice",
                                    "name"  => "third"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Radio Buttons",
                            "type"    => "radio",
                            "name"    => "myradiogroup",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice"
                                ),
                                array(
                                    "label" => "Second Choice"
                                ),
                                array(
                                    "label" => "Third Choice"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Horizontal Radio Buttons",
                            "type"    => "radio",
                            "horizontal" => true,
                            "name"    => "myradiogrouph",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice"
                                ),
                                array(
                                    "label" => "Second Choice"
                                ),
                                array(
                                    "label" => "Third Choice"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Dropdown",
                            "type"    => "select",
                            "name"    => "mydropdown",
                            "tooltip" => "This is the tooltip",
                            "choices" => array(
                                array(
                                    "label" => "First Choice",
                                    "value" => "first"
                                ),
                                array(
                                    "label" => "Second Choice",
                                    "value" => "second"
                                ),
                                array(
                                    "label" => "Third Choice",
                                    "value" => "third"
                                )
                            )
                        ),
                        array(
                            "label"   => "My Text Box",
                            "type"    => "text",
                            "name"    => "mytext",
                            "tooltip" => "This is the tooltip",
                            "class"   => "medium"
                        ),
                        array(
                            "label"   => "My Text Area",
                            "type"    => "textarea",
                            "name"    => "mytextarea",
                            "tooltip" => "This is the tooltip",
                            "class"   => "medium merge-tag-support mt-position-right"
                        ),
                        array(
                            "label"   => "My Hidden Field",
                            "type"    => "hidden",
                            "name"    => "myhidden"
                        ),
                        array(
                            "label"   => "My Custom Field",
                            "type"    => "my_custom_field_type",
                            "name"    => "my_custom_field"
                        )
                    )
                )
            );
        }

        public function settings_my_custom_field_type(){
            ?>
            <div>
                My custom field contains a few settings:
            </div>
            <?php
                $this->settings_text(
                    array(
                        "label" => "A textbox sub-field",
                        "name" => "subtext",
                        "default_value" => "change me"
                    )
                );
                $this->settings_checkbox(
                    array(
                        "label" => "A checkbox sub-field",
                        "choices" => array(
                            array(
                                "label" => "Activate",
                                "name" => "subcheck",
                                "default_value" => true
                            )

                        )
                    )
                );
        }

        public function plugin_settings_fields() {
            return array(
                array(
                    "title"  => "Simple Add-On Settings",
                    "fields" => array(
                        array(
                            "name"    => "mytextbox",
                            "tooltip" => "This is the tooltip",
                            "label"   => "This is the label",
                            "type"    => "text",
                            "class"   => "small"
                        )
                    )
                )
            );
        }

        public function scripts() {
            $scripts = array(
                array("handle"  => "my_script_js",
                      "src"     => $this->get_base_url() . "/js/my_script.js",
                      "version" => $this->_version,
                      "deps"    => array("jquery"),
                      "strings" => array(
                          'first'  => __("First Choice", "simpleaddon"),
                          'second' => __("Second Choice", "simpleaddon"),
                          'third'  => __("Third Choice", "simpleaddon")
                      ),
                      "enqueue" => array(
                          array(
                              "admin_page" => array("form_settings"),
                              "tab"        => "simpleaddon"
                          )
                      )
                ),

            );

            return array_merge(parent::scripts(), $scripts);
        }

        public function styles() {

            $styles = array(
                array("handle"  => "my_styles_css",
                      "src"     => $this->get_base_url() . "/css/my_styles.css",
                      "version" => $this->_version,
                      "enqueue" => array(
                          array("field_types" => array("poll"))
                      )
                )
            );

            return array_merge(parent::styles(), $styles);
        }



    }

    new GFSimpleAddOn();
}