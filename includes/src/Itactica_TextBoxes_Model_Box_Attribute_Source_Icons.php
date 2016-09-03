<?php
/**
 * Intenso Premium Theme
 * 
 * @category    Itactica
 * @package     Itactica_TextBoxes
 * @copyright   Copyright (c) 2014-2015 Itactica (http://www.itactica.com)
 * @license     http://getintenso.com/license
 */

class Itactica_TextBoxes_Model_Box_Attribute_Source_Icons extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
    /**
     * get possible values
     * @access public
     * @param bool $withEmpty
     * @param bool $defaultValues
     * @return array
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false){
        $options =  array(
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe616; Email'),
                'value' => 'icon-email'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe60e; Email 2'),
                'value' => 'icon-email-2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe601; Phone'),
                'value' => 'icon-phone'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe605; Secondary Menu'),
                'value' => 'icon-sec-menu'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe619; List'),
                'value' => 'icon-list'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a0; List 2'),
                'value' => 'icon-list2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a1; List 3'),
                'value' => 'icon-list3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe61a; Grid'),
                'value' => 'icon-grid'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe618; Checkbox'),
                'value' => 'icon_checkbox'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe617; Checkbox Checked'),
                'value' => 'icon-checkbox-checked'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe60f; Map Marker'),
                'value' => 'icon-mapmarker'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe610; Google+'),
                'value' => 'icon-googleplus'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe611; Pinterest'),
                'value' => 'icon-pinterest'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe612; YouTube'),
                'value' => 'icon-youtube'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe613; Instagram'),
                'value' => 'icon-instagram'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe614; Twitter'),
                'value' => 'icon-twitter'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe615; Facebook'),
                'value' => 'icon-facebook'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe61c; Vimeo'),
                'value' => 'icon-vimeo'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe622; LinkedIn'),
                'value' => 'icon-linkedin'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe60d; Compare'),
                'value' => 'icon-compare'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe60c; Heart'),
                'value' => 'icon-heart'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe60b; Wrench'),
                'value' => 'icon-wrench'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe60a; Gear'),
                'value' => 'icon-gear'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe609; Puzzle'),
                'value' => 'icon-puzzle'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe608; Home'),
                'value' => 'icon-home'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe607; User'),
                'value' => 'icon-user'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe672; User 2'),
                'value' => 'icon-user2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe674; User 3'),
                'value' => 'icon-user3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe676; User 4'),
                'value' => 'icon-user4'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe677; User 5'),
                'value' => 'icon-user5'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe673; Users'),
                'value' => 'icon-users'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe675; Users 2'),
                'value' => 'icon-users2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe606; Main menu (hamburguer)'),
                'value' => 'icon-main-menu'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe604; Close'),
                'value' => 'icon-close'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ba; Close 2'),
                'value' => 'icon-close2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe603; Edit'),
                'value' => 'icon-edit'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe600; Search'),
                'value' => 'icon-search'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6fb; Padlock'),
                'value' => 'icon-padlock'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe623; Office'),
                'value' => 'icon-office'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe624; Newspaper'),
                'value' => 'icon-newspaper'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe625; Pencil'),
                'value' => 'icon-pencil'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe626; Pencil 2'),
                'value' => 'icon-pencil2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe627; Quill'),
                'value' => 'icon-quill'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe628; Pen'),
                'value' => 'icon-pen'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe629; Droplet'),
                'value' => 'icon-droplet'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe62a; Paint format'),
                'value' => 'icon-paint-format'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe62b; Image'),
                'value' => 'icon-image'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe62c; Image 2'),
                'value' => 'icon-image2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe62d; Images'),
                'value' => 'icon-images'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe62e; Camera'),
                'value' => 'icon-camera'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe632; Camera 2'),
                'value' => 'icon-camera2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe62f; Music'),
                'value' => 'icon-music'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe630; Play'),
                'value' => 'icon-play'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe631; Film'),
                'value' => 'icon-film'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe633; Dice'),
                'value' => 'icon-dice'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe634; Bullhorn'),
                'value' => 'icon-bullhorn'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe635; Book'),
                'value' => 'icon-book'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe636; Books'),
                'value' => 'icon-books'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe637; Library'),
                'value' => 'icon-library'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe639; Profile'),
                'value' => 'icon-profile'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe638; File'),
                'value' => 'icon-file'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe63a; File 2'),
                'value' => 'icon-file2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe63b; File 3'),
                'value' => 'icon-file3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe63c; Folder'),
                'value' => 'icon-folder'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe63d; Folder open'),
                'value' => 'icon-folder-open'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe63e; Tag'),
                'value' => 'icon-tag'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe63f; Tags'),
                'value' => 'icon-tags'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe640; Barcode'),
                'value' => 'icon-barcode'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe641; QR code'),
                'value' => 'icon-qrcode'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe642; Ticket'),
                'value' => 'icon-ticket'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe602; Cart'),
                'value' => 'icon-cart'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe643; Cart 2'),
                'value' => 'icon-cart2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe644; Cart 3'),
                'value' => 'icon-cart3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe645; Cart 4'),
                'value' => 'icon-cart4'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe646; Coin'),
                'value' => 'icon-coin'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe647; Credit'),
                'value' => 'icon-credit'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe648; Calculate'),
                'value' => 'icon-calculate'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe649; Support'),
                'value' => 'icon-support'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe64a; Address book'),
                'value' => 'icon-address-book'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe64b; Notebook'),
                'value' => 'icon-notebook'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe64c; Pushpin'),
                'value' => 'icon-pushpin'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe64d; Location'),
                'value' => 'icon-location'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe64e; Location 2'),
                'value' => 'icon-location2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe64f; Compass'),
                'value' => 'icon-compass'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe650; Map'),
                'value' => 'icon-map'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe651; Map 2'),
                'value' => 'icon-map2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe652; History'),
                'value' => 'icon-history'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe653; Clock'),
                'value' => 'icon-clock'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe654; Clock 2'),
                'value' => 'icon-clock2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe655; Alarm'),
                'value' => 'icon-alarm'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe656; Alarm 2'),
                'value' => 'icon-alarm2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe657; Bell'),
                'value' => 'icon-bell'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe658; Stopwatch'),
                'value' => 'icon-stopwatch'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe659; Calendar'),
                'value' => 'icon-calendar'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe65a; Calendar 2'),
                'value' => 'icon-calendar2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe620; Print'),
                'value' => 'icon-print'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe65b; Keyboard'),
                'value' => 'icon-keyboard'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe65c; Screen'),
                'value' => 'icon-screen'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe65d; Laptop'),
                'value' => 'icon-laptop'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe65e; Mobile'),
                'value' => 'icon-mobile'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe65f; Mobile 2'),
                'value' => 'icon-mobile2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe660; Tablet'),
                'value' => 'icon-tablet'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe661; TV'),
                'value' => 'icon-tv'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe662; Drawer'),
                'value' => 'icon-drawer'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe663; Box add'),
                'value' => 'icon-box-add'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe664; Box remove'),
                'value' => 'icon-box-remove'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe665; Download'),
                'value' => 'icon-download'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe666; Upload'),
                'value' => 'icon-upload'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe667; Disk'),
                'value' => 'icon-disk'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe668; Undo'),
                'value' => 'icon-undo'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe669; Redo'),
                'value' => 'icon-redo'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe66a; Forward'),
                'value' => 'icon-forward'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe66b; Reply'),
                'value' => 'icon-reply'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe66c; Bubble'),
                'value' => 'icon-bubble'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe66f; Bubble 2'),
                'value' => 'icon-bubble2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe66d; Bubbles'),
                'value' => 'icon-bubbles'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe66e; Bubbles 2'),
                'value' => 'icon-bubbles2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe670; Bubbles 3'),
                'value' => 'icon-bubbles3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe671; Bubbles 4'),
                'value' => 'icon-bubbles4'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe678; Quotes left'),
                'value' => 'icon-quotes-left'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe679; Busy'),
                'value' => 'icon-busy'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe67a; Binoculars'),
                'value' => 'icon-binoculars'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe67b; Zoom in'),
                'value' => 'icon-zoomin'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe67c; Zoom out'),
                'value' => 'icon-zoomout'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe67d; Key'),
                'value' => 'icon-key'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe67e; Key 2'),
                'value' => 'icon-key2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe67f; Settings'),
                'value' => 'icon-settings'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe680; Equalizer'),
                'value' => 'icon-equalizer'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe681; Cogs'),
                'value' => 'icon-cogs'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe682; Wand'),
                'value' => 'icon-wand'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe683; Aid'),
                'value' => 'icon-aid'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe684; Bug'),
                'value' => 'icon-bug'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe685; Pie'),
                'value' => 'icon-pie'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe686; Stats'),
                'value' => 'icon-stats'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe687; Bars'),
                'value' => 'icon-bars'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe688; Gift'),
                'value' => 'icon-gift'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe689; Trophy'),
                'value' => 'icon-trophy'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe68a; Glass'),
                'value' => 'icon-glass'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe68b; Mug'),
                'value' => 'icon-mug'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe68c; Food'),
                'value' => 'icon-food'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe68d; Leaf'),
                'value' => 'icon-leaf'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe68e; Rocket'),
                'value' => 'icon-rocket'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe68f; Meter'),
                'value' => 'icon-meter'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe690; Meter 2'),
                'value' => 'icon-meter2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe691; Dashboard'),
                'value' => 'icon-dashboard'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe692; Hammer'),
                'value' => 'icon-hammer'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe693; Fire'),
                'value' => 'icon-fire'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe694; Lab'),
                'value' => 'icon-lab'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe695; Magnet'),
                'value' => 'icon-magnet'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe696; Briefcase'),
                'value' => 'icon-briefcase'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe697; Airplane'),
                'value' => 'icon-airplane'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe698; Truck'),
                'value' => 'icon-truck'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe699; Road'),
                'value' => 'icon-road'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe69a; Target'),
                'value' => 'icon-target'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe69b; Shield'),
                'value' => 'icon-shield'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe69c; Lightning'),
                'value' => 'icon-lightning'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe69d; Switch'),
                'value' => 'icon-switch'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe69e; Power cord'),
                'value' => 'icon-powercord'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe69f; Signup'),
                'value' => 'icon-signup'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a2; Numbered list'),
                'value' => 'icon-numbered-list'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a3; Cloud'),
                'value' => 'icon-cloud'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a4; Cloud download'),
                'value' => 'icon-cloud-download'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a5; Cloud upload'),
                'value' => 'icon-cloud-upload'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a6; Globe'),
                'value' => 'icon-globe'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a7; Earth'),
                'value' => 'icon-earth'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a8; Link'),
                'value' => 'icon-link'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6a9; Flag'),
                'value' => 'icon-flag'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6aa; Attachment'),
                'value' => 'icon-attachment'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe61d; Eye'),
                'value' => 'icon-eye'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ab; Star'),
                'value' => 'icon-star'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ac; Thumbs up'),
                'value' => 'icon-thumbs-up'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ad; Thumbs up 2'),
                'value' => 'icon-thumbs-up2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ae; Happy'),
                'value' => 'icon-happy'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6af; Smiley'),
                'value' => 'icon-smiley'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b0; Sad'),
                'value' => 'icon-sad'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b1; Point up'),
                'value' => 'icon-point-up'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b2; Point right'),
                'value' => 'icon-point-right'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b3; Point down'),
                'value' => 'icon-point-down'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b4; Point left'),
                'value' => 'icon-point-left'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b5; Warning'),
                'value' => 'icon-warning'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe621; Notification'),
                'value' => 'icon-notification'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b6; Question'),
                'value' => 'icon-question'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b7; Info'),
                'value' => 'icon-info'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b8; Info 2'),
                'value' => 'icon-info2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6b9; Blocked'),
                'value' => 'icon-blocked'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6bb; Checkmark'),
                'value' => 'icon-checkmark'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6bc; Minus'),
                'value' => 'icon-minus'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6bd; Plus'),
                'value' => 'icon-plus'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6be; Enter'),
                'value' => 'icon-enter'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6bf; Exit'),
                'value' => 'icon-exit'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c0; Loop 2'),
                'value' => 'icon-loop2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c1; Loop 3'),
                'value' => 'icon-loop3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c2; Shuffle'),
                'value' => 'icon-shuffle'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c3; Arrow up left'),
                'value' => 'icon-arrow-up-left'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c4; Arrow up'),
                'value' => 'icon-arrow-up'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c5; Arrow up right'),
                'value' => 'icon-arrow-up-right'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c6; Arrow right'),
                'value' => 'icon-arrow-right'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c7; Arrow down right'),
                'value' => 'icon-arrow-down-right'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c8; Arrow down'),
                'value' => 'icon-arrow-down'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6c9; Arrow down left'),
                'value' => 'icon-arrow-down-left'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ca; Arrow left'),
                'value' => 'icon-arrow-left'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6cb; Arrow up left 2'),
                'value' => 'icon-arrow-up-left2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6cc; Arrow up 2'),
                'value' => 'icon-arrow-up2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6cd; Arrow up right 2'),
                'value' => 'icon-arrow-up-right2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ce; Arrow right 2'),
                'value' => 'icon-arrow-right2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6cf; Arrow down right 2'),
                'value' => 'icon-arrow-down-right2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d0; Arrow down 2'),
                'value' => 'icon-arrow-down2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d1; Arrow down left 2'),
                'value' => 'icon-arrow-down-left2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d2; Arrow left 2'),
                'value' => 'icon-arrow-left2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d3; Arrow up left 3'),
                'value' => 'icon-arrow-up-left3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d4; Arrow up 3'),
                'value' => 'icon-arrow-up3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d5; Arrow up right 3'),
                'value' => 'icon-arrow-up-right3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d6; Arrow right 3'),
                'value' => 'icon-arrow-right3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d7; Arrow down right 3'),
                'value' => 'icon-arrow-down-right3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d8; icon-arrow-down3'),
                'value' => 'icon-icon-arrow-down3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6d9; Arrow down left 3'),
                'value' => 'icon-arrow-down-left3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6da; Arrow left 3'),
                'value' => 'icon-arrow-left3'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6db; Scissors'),
                'value' => 'icon-scissors'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6dc; Filter'),
                'value' => 'icon-filter'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6dd; Filter 2'),
                'value' => 'icon-filter2'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6de; Bold'),
                'value' => 'icon-bold'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6df; Underline'),
                'value' => 'icon-underline'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e0; Italic'),
                'value' => 'icon-italic'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e1; Table'),
                'value' => 'icon-table'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e2; Paragraph left'),
                'value' => 'icon-paragraph-left'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e3; Paragraph center'),
                'value' => 'icon-paragraph-center'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e4; Paragraph right'),
                'value' => 'icon-paragraph-right'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e5; Paragraph justify'),
                'value' => 'icon-paragraph-justify'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e6; Picassa'),
                'value' => 'icon-picassa'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e7; Android'),
                'value' => 'icon-android'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e8; Windows'),
                'value' => 'icon-windows'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6e9; Windows 8'),
                'value' => 'icon-windows8'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ea; Paypal'),
                'value' => 'icon-paypal'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6eb; LibreOffice'),
                'value' => 'icon-libreoffice'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ec; File PDF'),
                'value' => 'icon-file-pdf'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ed; File OpenOffice'),
                'value' => 'icon-file-openoffice'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ee; File Word'),
                'value' => 'icon-file-word'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6ef; File Excel'),
                'value' => 'icon-file-excel'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f0; File Zip'),
                'value' => 'icon-file-zip'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f1; File PowerPoint'),
                'value' => 'icon-file-powerpoint'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f2; File XML'),
                'value' => 'icon-file-xml'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f3; File CSS'),
                'value' => 'icon-file-css'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f4; HTML5'),
                'value' => 'icon-html5'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f5; Chrome'),
                'value' => 'icon-chrome'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f6; Firefox'),
                'value' => 'icon-firefox'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f7; IE - Internet Explorer'),
                'value' => 'icon-IE'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f8; Opera'),
                'value' => 'icon-opera'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6f9; Safari'),
                'value' => 'icon-safari'
            ),
            array(
                'label' => Mage::helper('itactica_textboxes')->__('&#xe6fa; IcoMoon'),
                'value' => 'icon-IcoMoon'
            ),
        );
        if ($withEmpty) {
            array_unshift($options, array('label'=>'', 'value'=>''));
        }
        return $options;

    }
    /**
     * get options as array
     * @access public
     * @param bool $withEmpty
     * @return string
     */
    public function getOptionsArray($withEmpty = true) {
        $options = array();
        foreach ($this->getAllOptions($withEmpty) as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }
    /**
     * get option text
     * @access public
     * @param mixed $value
     * @return string
     */
    public function getOptionText($value) {
        $options = $this->getOptionsArray();
        if (!is_array($value)) {
            $value = array($value);
        }
        $texts = array();
        foreach ($value as $v) {
            if (isset($options[$v])) {
                $texts[] = $options[$v];
            }
        }
        return implode(', ', $texts);
    }
}
