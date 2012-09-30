<?php
/**
 * Class for manage a basic configurations
 */

/**
 * Class for manage a basic configurations
 *
 * @package core
 *
 * @property $Date_format    date format
 * @property $Time_zone      time zone
 * @property $Time_Format    time format
 * @property $File_prev      privileges to create,save files
 * @property $Folder_prev    privileges to create,save folders
 * @property $Admin_Email    administrator email
 * @property $Admin_id       administrator id
 * @property $Lang           actual language
 * @property $TimeZones      all time zones downloaded from http://stackoverflow.com/questions/4755704/php-timezone-list
 * @property $DateFormats    date formats array to choose
 * @property $TimeFormats    time formats array to choose
 * @property $Template       folder with template
 * @property $AllTemplates   list of all templates
 * */
class Configuration
{

    /**
     * Format for date
     * @var string
     */
    protected $Date_format;

    /**
     * Timezone
     * @var string
     */
    protected $Time_zone;

    /**
     * Format for time in date
     * @var string
     */
    protected $Time_Format;

    /**
     * File privileges
     * @var string
     */
    protected $File_prev;

    /**
     * Folder privileges
     * @var  string
     */
    protected $Folder_prev;

    /**
     * AdminC Email
     * @var  string
     */
    protected $Admin_Email;

    /**
     * AdminC User id
     * @var string
     */
    protected $Admin_id;

    /**
     * Language of site
     * @var string
     */
    protected $Lang;

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
        $db = ApplicationDB::connectDB();
        $sql = 'SELECT * FROM configuration';
        $stmt = $db->prepare($sql);
        try {
            if ($stmt->execute()) {
                $obj = $stmt->fetch(PDO::FETCH_OBJ);
                $this->Date_format = $obj->Date_format;
                $this->Time_zone = $obj->Time_zone;
                $this->File_prev = $obj->File_prev;
                $this->Folder_prev = $obj->Folder_prev;
                $this->Admin_Email = $obj->Admin_Email;
                $this->Admin_id = $obj->Admin_id;
                $this->Lang = $obj->Lang;
                $this->Time_Format = $obj->Time_Format;
                $this->Template = $obj->Template;
            }

        } catch (ErrorException $e) {
            echo  $e->getMessage();
        }


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
        $db = ApplicationDB::connectDB();

        $sql = "UPDATE configuration SET DATE_FORMAT = :Date_format , TIME_ZONE  = :Time_zone , FILE_PREV = :File_prev, FOLDER_PREV = :Folder_prev , ADMIN_EMAIL = :Admin_Email , LANG = :Lang , TIME_FORMAT = :Time_Format , TEMPLATE = :Template  WHERE ID_CONFIGURATION = 1";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":Date_format", $this->Date_format, PDO::PARAM_STR);
        $stmt->bindParam(":Time_zone", $this->Time_zone, PDO::PARAM_STR);
        $stmt->bindParam(":File_prev", $this->File_prev, PDO::PARAM_STR);
        $stmt->bindParam(":Folder_prev", $this->Folder_prev, PDO::PARAM_STR);
        $stmt->bindParam(":Admin_Email", $this->Admin_Email, PDO::PARAM_STR);
        $stmt->bindParam(":Lang", $this->Lang, PDO::PARAM_STR);
        $stmt->bindParam(":Time_Format", $this->Time_Format, PDO::PARAM_STR);
        $stmt->bindParam(":Template", $this->Template, PDO::PARAM_STR);

        try {
            return $stmt->execute();

        } catch (ErrorException $e) {
            echo $e->getMessage();
        }
        return false;
    }


    /**
     * Set AdminC Email
     * @param string $Admin_Email
     */
    public function setAdminEmail($Admin_Email)
    {
        $this->Admin_Email = $Admin_Email;
    }

    /**
     * Get AdminC Email
     * @return mixed
     */
    public function getAdminEmail()
    {
        return $this->Admin_Email;
    }

    /**
     * Set admin user id
     * @param string $Admin_id
     */
    public function setAdminId($Admin_id)
    {
        $this->Admin_id = $Admin_id;
    }

    /**
     * Get Set admin user id
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->Admin_id;
    }

    /**
     * Set Date Format
     * @param string $Date_format
     */
    public function setDateFormat($Date_format)
    {
        $this->Date_format = $Date_format;
    }

    /**
     * Return Date Format
     * @return mixed
     */
    public function getDateFormat()
    {
        return $this->Date_format;
    }

    /**
     * Set file privileges
     * @param string $File_prev
     */
    public function setFilePrev($File_prev)
    {
        $this->File_prev = $File_prev;
    }

    /**
     * Return file privileges
     * @return mixed
     */
    public function getFilePrev()
    {
        return $this->File_prev;
    }

    /**
     * Set folder privileges
     * @param string $Folder_prev
     */
    public function setFolderPrev($Folder_prev)
    {
        $this->Folder_prev = $Folder_prev;
    }

    /**
     * Return folder privileges
     * @return mixed
     */
    public function getFolderPrev()
    {
        return $this->Folder_prev;
    }

    /**
     * Set Time zone
     * @param string $Time_zone
     */
    public function setTimeZone($Time_zone)
    {
        $this->Time_zone = $Time_zone;
    }

    /**
     * Return Time zone
     * @return mixed
     */
    public function getTimeZone()
    {
        return $this->Time_zone;
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
        $this->Time_Format = $Time_Format;
    }

    /**
     * Get Time format
     * @return mixed
     */
    public function getTimeFormat()
    {
        return $this->Time_Format;
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
     * List of all templates
     * @return array
     */
    public function getAllTemplates()
    {
        $files = FileManager::getFolders(Application::getBaseDir() . "templates");
        unset($files[0]);
        unset($files[1]);
        $Files = array();
        foreach ($files as $key => $value) {
            $Files[$value] = $value;
        }
        return $this->AllTemplates = $Files;
    }


}
