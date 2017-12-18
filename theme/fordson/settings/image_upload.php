<?php

defined('MOODLE_INTERNAL') || die();

//Sangita

/* Logo Setting */

$page = new admin_settingpage('theme_fordson_imageupload', get_string('imageupload', 'theme_fordson'));

/*heading*/
$name = 'theme_fordson/heading';
$title = get_string('heading', 'theme_fordson');
$description = get_string('hdes', 'theme_fordson');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


// Show hide user enrollment toggle. Global Checkbox
$name = 'theme_fordson/globalsetting';
$title = get_string('globalsetting', 'theme_fordson');
$description = get_string('globalsetting_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);


/*Insert First Logos*/

$name = 'theme_fordson/logo';
$title = get_string('logo', 'theme_fordson');
$description = get_string('logodesc', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle. First Checkbox
$name = 'theme_fordson/showlogo';
$title = get_string('showlogo', 'theme_fordson');
$description = get_string('showlogo_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

/*Insert Second Logos*/
$name = 'theme_fordson/logo2';
$title = get_string('logo2', 'theme_fordson');
$description = get_string('logodesc2', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo2', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle.Second Checkbox
$name = 'theme_fordson/showlogo2';
$title = get_string('showlogo2', 'theme_fordson');
$description = get_string('showlogo2_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

/*Insert Third Logos*/
$name = 'theme_fordson/logo3';
$title = get_string('logo3', 'theme_fordson');
$description = get_string('logodesc3', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo3', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle.Third Checkbox
$name = 'theme_fordson/showlogo3';
$title = get_string('showlogo3', 'theme_fordson');
$description = get_string('showlogo3_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

/*Insert Fourth Logos*/
$name = 'theme_fordson/logo4';
$title = get_string('logo4', 'theme_fordson');
$description = get_string('logodesc4', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo4', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle.Fourth Checkbox
$name = 'theme_fordson/showlogo4';
$title = get_string('showlogo4', 'theme_fordson');
$description = get_string('showlogo4_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

/*Insert Fifth Logos*/
$name = 'theme_fordson/logo5';
$title = get_string('logo5', 'theme_fordson');
$description = get_string('logodesc5', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo5', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle.Fifth Checkbox
$name = 'theme_fordson/showlogo5';
$title = get_string('showlogo5', 'theme_fordson');
$description = get_string('showlogo5_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

/*Insert Sixth Logos*/
$name = 'theme_fordson/logo6';
$title = get_string('logo6', 'theme_fordson');
$description = get_string('logodesc6', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo6', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle.Sixth Checkbox
$name = 'theme_fordson/showlogo6';
$title = get_string('showlogo6', 'theme_fordson');
$description = get_string('showlogo6_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

/*Insert Seventh Logos*/
$name = 'theme_fordson/logo7';
$title = get_string('logo7', 'theme_fordson');
$description = get_string('logodesc7', 'theme_fordson');
$opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
$setting = new admin_setting_configstoredfile($name, $title, $description, 'logo7', 0, $opts);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

// Show hide user enrollment toggle.Sixth Checkbox
$name = 'theme_fordson/showlogo7';
$title = get_string('showlogo7', 'theme_fordson');
$description = get_string('showlogo7_desc', 'theme_fordson');
$default = 1;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$page->add($setting);

$settings->add($page);



