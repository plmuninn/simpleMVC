<?php
/**
 * Class for manage a basic configurations
 */

/**
 * Class for manage a basic configurations
 *
 * @package core
 *
 * */
class Configuration
{

    /**
     * Format for date
     * @var string
     */
    protected $DateFormat;

    /**
     * Timezone
     * @var string
     */
    protected $TimeZone;

    /**
     * Format for time in date
     * @var string
     */
    protected $TimeFormat;

    /**
     * File privileges
     * @var string
     */
    protected $FilePrev;

    /**
     * Folder privileges
     * @var  string
     */
    protected $FolderPrev;

    /**
     * Language of site
     * @var string
     */
    protected $Lang;

    /**
     * Name of database
     * @var
     */
    protected $DBName;

    /**
     * Address to database
     * @var
     */
    protected $DBAddress;

    /**
     * Database User Login
     * @var
     */
    protected $DBUser;

    /**
     * Database User Password
     * @var
     */
    protected $DBPassword;

    /**
     * Database connection charset encoding
     * @var
     */
    protected $DBCharset;

    /**
     * Database Type (ex. mysql)
     * @var
     */
    protected $DBType;

    /**
     * Website global title
     * @var
     */
    protected $SiteTitle;

    /**
     * Website coding charset
     * @var
     */
    protected $SiteCharset;

    /**
     * Time Zones to choose
     * @var array
     */
    protected $TimeZones = array(
        'Pacific/Midway' => "(GMT-11:00) Midway Island",
        'US/Samoa' => "(GMT-11:00) Samoa",
        'US/Hawaii' => "(GMT-10:00) Hawaii",
        'US/Alaska' => "(GMT-09:00) Alaska",
        'US/Pacific' => "(GMT-08:00) Pacific Time (US &amp; Canada)",
        'America/Tijuana' => "(GMT-08:00) Tijuana",
        'US/Arizona' => "(GMT-07:00) Arizona",
        'US/Mountain' => "(GMT-07:00) Mountain Time (US &amp; Canada)",
        'America/Chihuahua' => "(GMT-07:00) Chihuahua",
        'America/Mazatlan' => "(GMT-07:00) Mazatlan",
        'America/Mexico_City' => "(GMT-06:00) Mexico City",
        'America/Monterrey' => "(GMT-06:00) Monterrey",
        'Canada/Saskatchewan' => "(GMT-06:00) Saskatchewan",
        'US/Central' => "(GMT-06:00) Central Time (US &amp; Canada)",
        'US/Eastern' => "(GMT-05:00) Eastern Time (US &amp; Canada)",
        'US/East-Indiana' => "(GMT-05:00) Indiana (East)",
        'America/Bogota' => "(GMT-05:00) Bogota",
        'America/Lima' => "(GMT-05:00) Lima",
        'America/Caracas' => "(GMT-04:30) Caracas",
        'Canada/Atlantic' => "(GMT-04:00) Atlantic Time (Canada)",
        'America/La_Paz' => "(GMT-04:00) La Paz",
        'America/Santiago' => "(GMT-04:00) Santiago",
        'Canada/Newfoundland' => "(GMT-03:30) Newfoundland",
        'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
        'Greenland' => "(GMT-03:00) Greenland",
        'Atlantic/Stanley' => "(GMT-02:00) Stanley",
        'Atlantic/Azores' => "(GMT-01:00) Azores",
        'Atlantic/Cape_Verde' => "(GMT-01:00) Cape Verde Is.",
        'Africa/Casablanca' => "(GMT) Casablanca",
        'Europe/Dublin' => "(GMT) Dublin",
        'Europe/Lisbon' => "(GMT) Lisbon",
        'Europe/London' => "(GMT) London",
        'Africa/Monrovia' => "(GMT) Monrovia",
        'Europe/Amsterdam' => "(GMT+01:00) Amsterdam",
        'Europe/Belgrade' => "(GMT+01:00) Belgrade",
        'Europe/Berlin' => "(GMT+01:00) Berlin",
        'Europe/Bratislava' => "(GMT+01:00) Bratislava",
        'Europe/Brussels' => "(GMT+01:00) Brussels",
        'Europe/Budapest' => "(GMT+01:00) Budapest",
        'Europe/Copenhagen' => "(GMT+01:00) Copenhagen",
        'Europe/Ljubljana' => "(GMT+01:00) Ljubljana",
        'Europe/Madrid' => "(GMT+01:00) Madrid",
        'Europe/Paris' => "(GMT+01:00) Paris",
        'Europe/Prague' => "(GMT+01:00) Prague",
        'Europe/Rome' => "(GMT+01:00) Rome",
        'Europe/Sarajevo' => "(GMT+01:00) Sarajevo",
        'Europe/Skopje' => "(GMT+01:00) Skopje",
        'Europe/Stockholm' => "(GMT+01:00) Stockholm",
        'Europe/Vienna' => "(GMT+01:00) Vienna",
        'Europe/Warsaw' => "(GMT+01:00) Warsaw",
        'Europe/Zagreb' => "(GMT+01:00) Zagreb",
        'Europe/Athens' => "(GMT+02:00) Athens",
        'Europe/Bucharest' => "(GMT+02:00) Bucharest",
        'Africa/Cairo' => "(GMT+02:00) Cairo",
        'Africa/Harare' => "(GMT+02:00) Harare",
        'Europe/Helsinki' => "(GMT+02:00) Helsinki",
        'Europe/Istanbul' => "(GMT+02:00) Istanbul",
        'Asia/Jerusalem' => "(GMT+02:00) Jerusalem",
        'Europe/Kiev' => "(GMT+02:00) Kyiv",
        'Europe/Minsk' => "(GMT+02:00) Minsk",
        'Europe/Riga' => "(GMT+02:00) Riga",
        'Europe/Sofia' => "(GMT+02:00) Sofia",
        'Europe/Tallinn' => "(GMT+02:00) Tallinn",
        'Europe/Vilnius' => "(GMT+02:00) Vilnius",
        'Asia/Baghdad' => "(GMT+03:00) Baghdad",
        'Asia/Kuwait' => "(GMT+03:00) Kuwait",
        'Europe/Moscow' => "(GMT+03:00) Moscow",
        'Africa/Nairobi' => "(GMT+03:00) Nairobi",
        'Asia/Riyadh' => "(GMT+03:00) Riyadh",
        'Europe/Volgograd' => "(GMT+03:00) Volgograd",
        'Asia/Tehran' => "(GMT+03:30) Tehran",
        'Asia/Baku' => "(GMT+04:00) Baku",
        'Asia/Muscat' => "(GMT+04:00) Muscat",
        'Asia/Tbilisi' => "(GMT+04:00) Tbilisi",
        'Asia/Yerevan' => "(GMT+04:00) Yerevan",
        'Asia/Kabul' => "(GMT+04:30) Kabul",
        'Asia/Yekaterinburg' => "(GMT+05:00) Ekaterinburg",
        'Asia/Karachi' => "(GMT+05:00) Karachi",
        'Asia/Tashkent' => "(GMT+05:00) Tashkent",
        'Asia/Kolkata' => "(GMT+05:30) Kolkata",
        'Asia/Kathmandu' => "(GMT+05:45) Kathmandu",
        'Asia/Almaty' => "(GMT+06:00) Almaty",
        'Asia/Dhaka' => "(GMT+06:00) Dhaka",
        'Asia/Novosibirsk' => "(GMT+06:00) Novosibirsk",
        'Asia/Bangkok' => "(GMT+07:00) Bangkok",
        'Asia/Jakarta' => "(GMT+07:00) Jakarta",
        'Asia/Krasnoyarsk' => "(GMT+07:00) Krasnoyarsk",
        'Asia/Chongqing' => "(GMT+08:00) Chongqing",
        'Asia/Hong_Kong' => "(GMT+08:00) Hong Kong",
        'Asia/Irkutsk' => "(GMT+08:00) Irkutsk",
        'Asia/Kuala_Lumpur' => "(GMT+08:00) Kuala Lumpur",
        'Australia/Perth' => "(GMT+08:00) Perth",
        'Asia/Singapore' => "(GMT+08:00) Singapore",
        'Asia/Taipei' => "(GMT+08:00) Taipei",
        'Asia/Ulaanbaatar' => "(GMT+08:00) Ulaan Bataar",
        'Asia/Urumqi' => "(GMT+08:00) Urumqi",
        'Asia/Seoul' => "(GMT+09:00) Seoul",
        'Asia/Tokyo' => "(GMT+09:00) Tokyo",
        'Asia/Yakutsk' => "(GMT+09:00) Yakutsk",
        'Australia/Adelaide' => "(GMT+09:30) Adelaide",
        'Australia/Darwin' => "(GMT+09:30) Darwin",
        'Australia/Brisbane' => "(GMT+10:00) Brisbane",
        'Australia/Canberra' => "(GMT+10:00) Canberra",
        'Pacific/Guam' => "(GMT+10:00) Guam",
        'Australia/Hobart' => "(GMT+10:00) Hobart",
        'Australia/Melbourne' => "(GMT+10:00) Melbourne",
        'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
        'Australia/Sydney' => "(GMT+10:00) Sydney",
        'Asia/Vladivostok' => "(GMT+10:00) Vladivostok",
        'Asia/Magadan' => "(GMT+11:00) Magadan",
        'Pacific/Auckland' => "(GMT+12:00) Auckland",
        'Pacific/Fiji' => "(GMT+12:00) Fiji",
        'Asia/Kamchatka' => "(GMT+12:00) Kamchatka",
    );

    /**
     * Date formats to choose
     * @var array
     */
    protected $DateFormats = array(
        "1/17/2006 (mm/dd/y)" => "m/d/y",
        "17/1/2006 (dd/mm/y)" => "d/m/y",
        "1-17-2006 (mm-dd-y)" => "m-d-y",
        "17-1-2006 (dd-mm-y)" => "d-m-y",
        "1.17.2006 (mm.dd.y)" => "m.d.y",
        "17.1.2006 (dd.mm.y)" => "d.m.y",
    );

    /**
     * Time formats to choose
     * @var array
     */
    protected $TimeFormats = array(
        " 16:45 (H:i)" => "H:i",
        " 16:45:58 (H:i:s)" => "H:i:s",
        " 16/45 (H/i)" => "H/i",
        " 16/45/58 (H/i/s)" => "H/i/s",
        " 16-45 (H-i)" => "H-i",
        " 16-45-58 (H-i-s)" => "H-i-s",
        "4:45 pm. (g:i a.)" => "g:i a.",
        "04:45 PM.(h:i A.)" => "h:i A.",
        "4/45 pm. (g/i a.)" => "g/i a.",
        "04/45 PM.(h/i A.)" => "h/i A.",
        "4-45 pm. (g-i a.)" => "g-i a.",
        "04-45 PM.(h-i A.)" => "h-i A.",

    );

    /**
     * Which template you are using
     * @var
     */
    protected $Template;

    /**
     * Templates to choose
     * @var array
     */
    protected $AllTemplates = array();

    /**
     * Construct map Database record to Object
     */
    function __construct()
    {
        $obj = self::getConfig();

        /*Setting DB Config*/
        $this->DBAddress = $obj->database->address;
        $this->DBName = $obj->database->name;
        $this->DBType = $obj->database->type;
        $this->DBUser = $obj->database->user;
        $this->DBPassword = $obj->database->password;
        $this->DBCharset = $obj->database->charset;

        /*Setting system config*/
        $this->DateFormat = $obj->settings->date_format;
        $this->TimeFormat = $obj->settings->time_format;
        $this->TimeZone = $obj->settings->time_zone;
        $this->FilePrev = $obj->settings->file_prev;
        $this->FolderPrev = $obj->settings->folder_prev;
        $this->Template = $obj->settings->template;
        $this->Lang = $obj->settings->lang;

        /*Setting website config*/
        $this->SiteTitle = $obj->settings->title;
        $this->SiteCharset = $obj->settings->charset;

        self::setGlobals();
    }

    /**
     * Empty
     */
    function __destruct()
    {
    }

    /**
     * Save Object variables to Database
     * @return bool if execute was ok is true else is false
     */
    public function save()
    {
        $config = new DOMDocument('1.0', 'UTF-8');
        $root = $config->createElement("config");
        $root = $config->appendChild($root);
        $database = $config->createElement("database");
        $database = $root->appendChild($database);
        $database->appendChild($config->createElement('type',$this->DBType));
        $database->appendChild($config->createElement('name',$this->DBName));
        $database->appendChild($config->createElement('user',$this->DBUser));
        $database->appendChild($config->createElement('password',$this->DBPassword));
        $database->appendChild($config->createElement('address',$this->DBAddress));
        $database->appendChild($config->createElement('charset',$this->DBCharset));
        $settings = $config->createElement("settings");
        $settings = $root->appendChild($settings);
        $settings->appendChild($config->createElement('title',$this->SiteTitle));
        $settings->appendChild($config->createElement('charset',$this->SiteCharset));
        $settings->appendChild($config->createElement('template',$this->Template));
        $settings->appendChild($config->createElement('date_format',$this->DateFormat));
        $settings->appendChild($config->createElement('time_zone',$this->TimeZone));
        $settings->appendChild($config->createElement('time_format',$this->TimeFormat));
        $settings->appendChild($config->createElement('file_prev',$this->FilePrev));
        $settings->appendChild($config->createElement('folder_prev',$this->FolderPrev));
        $settings->appendChild($config->createElement('lang',$this->Lang));
        $config->save(BASE_DIR."admin/config/config.xml");
        return false;
    }

    /**
     * List of all templates
     * @return array
     */
    public function getAllTemplates()
    {
        $files = FileManager::getFolders(Application::getBaseDir() . "templates");
        unset($files[0]);
        unset($files[1]);
        $Files = array();
        foreach ($files as $value) {
            $Files[$value] = $value;
        }
        return $this->AllTemplates = $Files;
    }

    /**
     * Create clean config if config is not exists
     */
    public function cleanConfig(){
        $config = new DOMDocument('1.0', 'UTF-8');
        $root = $config->createElement("config");
        $root = $config->appendChild($root);
        $database = $config->createElement("database");
        $database = $root->appendChild($database);
        $database->appendChild($config->createElement('type','mysql'));
        $database->appendChild($config->createElement('name',''));
        $database->appendChild($config->createElement('user',''));
        $database->appendChild($config->createElement('password',''));
        $database->appendChild($config->createElement('address','localhost'));
        $database->appendChild($config->createElement('charset','utf8'));
        $settings = $config->createElement("settings");
        $settings = $root->appendChild($settings);
        $settings->appendChild($config->createElement('title','Default Title'));
        $settings->appendChild($config->createElement('charset','utf-8'));
        $settings->appendChild($config->createElement('template','default'));
        $settings->appendChild($config->createElement('time_zone','(GMT) London'));
        $settings->appendChild($config->createElement('date_format','H:i'));
        $settings->appendChild($config->createElement('time_format','m/d/y'));
        $settings->appendChild($config->createElement('file_prev','0777'));
        $settings->appendChild($config->createElement('folder_prev','0777'));
        $settings->appendChild($config->createElement('lang','eng'));
        $config->save(BASE_DIR."admin/config/config.xml");
    }

    /**
     * Return config object
     * @return object
     */
    public function getConfig(){
        if(!file_exists(BASE_DIR."admin/config/config.xml"))
            self::cleanConfig();
        return simplexml_load_file(BASE_DIR."admin/config/config.xml");
    }

    /**
     * Setting system globals values
     */
    private function setGlobals(){
        if(!defined("SITE_TITLE") && !defined("SITE_CHARSET")){
        define("SITE_TITLE",$this->SiteTitle);
        define("SITE_CHARSET", $this->SiteCharset);
        }
    }

    /**
     * Set Date Format
     * @param string $Date_format
     */
    public function setDateFormat($Date_format)
    {
        $this->DateFormat = $Date_format;
    }

    /**
     * Return Date Format
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->DateFormat;
    }

    /**
     * Set file privileges
     * @param string $File_prev
     */
    public function setFilePrev($File_prev)
    {
        $this->FilePrev = $File_prev;
    }

    /**
     * Return file privileges
     * @return mixed
     */
    public function getFilePrev()
    {
        return $this->FilePrev;
    }

    /**
     * Set folder privileges
     * @param string $Folder_prev
     */
    public function setFolderPrev($Folder_prev)
    {
        $this->FolderPrev = $Folder_prev;
    }

    /**
     * Return folder privileges
     * @return mixed
     */
    public function getFolderPrev()
    {
        return $this->FolderPrev;
    }

    /**
     * Set Time zone
     * @param string $Time_zone
     */
    public function setTimeZone($Time_zone)
    {
        $this->TimeZone = $Time_zone;
    }

    /**
     * Return Time zone
     * @return mixed
     */
    public function getTimeZone()
    {
        return $this->TimeZone;
    }

    /**
     * Change actual site language
     * @param string $Lang
     */
    public function setLang($Lang)
    {
        $this->Lang = $Lang;
    }

    /**
     * Return actual language
     * @return mixed
     */
    public function getLang()
    {
        return $this->Lang;
    }

    /**
     * Return all Date formats
     * @return mixed
     */
    public function getDateFormats()
    {
        return $this->DateFormats;
    }

    /**
     * Return all Time zones
     * @return mixed
     */
    public function getTimeZones()
    {
        return $this->TimeZones;
    }

    /**
     * Return all Time formats
     * @return mixed
     */
    public function getTimeFormats()
    {
        return $this->TimeFormats;
    }

    /**
     * Set Time format
     * @param string $Time_Format
     */
    public function setTimeFormat($Time_Format)
    {
        $this->TimeFormat = $Time_Format;
    }

    /**
     * Get Time format
     * @return mixed
     */
    public function getTimeFormat()
    {
        return $this->TimeFormat;
    }

    /**
     * Set actual template
     * @param string $Template
     */
    public function setTemplate($Template)
    {
        $this->Template = $Template;
    }

    /**
     * Return actual template
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->Template;
    }

    /**
     * Setting Database address. Default localhost.
     * @param $DBAddress
     */
    public function setDBAddress($DBAddress)
    {
        $this->DBAddress = $DBAddress;
    }

    /**
     * Return Database address.
     * @return mixed
     */
    public function getDBAddress()
    {
        return $this->DBAddress;
    }

    /**
     * Setting Database connection encoding. Default utf8.
     * @param $DBCharset
     */
    public function setDBCharset($DBCharset)
    {
        $this->DBCharset = $DBCharset;
    }

    /**
     * Return Database connection encoding.
     * @return mixed
     */
    public function getDBCharset()
    {
        return $this->DBCharset;
    }

    /**
     * Setting database name;
     * @param $DBName
     */
    public function setDBName($DBName)
    {
        $this->DBName = $DBName;
    }

    /**
     * Return database name;
     * @return mixed
     */
    public function getDBName()
    {
        return $this->DBName;
    }

    /**
     * Set Database password for DB connection.;
     * @param $DBPassword
     */
    public function setDBPassword($DBPassword)
    {
        $this->DBPassword = $DBPassword;
    }

    /**
     * Return Database password for DB connection.
     * @return mixed
     */
    public function getDBPassword()
    {
        return $this->DBPassword;
    }

    /**
     * Setting Database type (ex. mysql)
     * @param $DBType
     */
    public function setDBType($DBType)
    {
        $this->DBType = $DBType;
    }

    /**
     * Return Database type (ex. mysql)
     * @return mixed
     */
    public function getDBType()
    {
        return $this->DBType;
    }

    /**
     * Setting Database User for DB connection
     * @param $DBUser
     */
    public function setDBUser($DBUser)
    {
        $this->DBUser = $DBUser;
    }

    /**
     * Return Database User for DB connection
     * @return mixed
     */
    public function getDBUser()
    {
        return $this->DBUser;
    }

    /**
     * Setting site charset
     * @param  $SiteCharset
     */
    public function setSiteCharset($SiteCharset)
    {
        $this->SiteCharset = $SiteCharset;
    }

    /**
     * Return site coding charset
     * @return
     */
    public function getSiteCharset()
    {
        return $this->SiteCharset;
    }

    /**
     * Setting website title
     * @param  $SiteTitle
     */
    public function setSiteTitle($SiteTitle)
    {
        $this->SiteTitle = $SiteTitle;
    }

    /**
     * Return config title
     * @return
     */
    public function getSiteTitle()
    {
        return $this->SiteTitle;
    }

}
