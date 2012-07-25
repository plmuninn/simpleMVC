<?php
/**
 * Application instance class
 */

/**
 * Class of application instance. Have all important
 * vars and methods.
 *
 * @package core
 *
 * @property-read string $homeUrl url form homepage
 * @property-read string $baseDir path to file load
 * @property string $siteTitle home site title
 * @property string $pageTitle actual site title
 * */

class Application extends  Configuration
{
    /**
     * Url form homepage
     * @var string
     */
    private $homeUrl;

    /**
     * Path to file load
     * @var string
     */
    private static  $baseDir = BASE_DIR;

    /**
     * Home site title
     * @var string
     */
    private $siteTitle;

    /**
     * Actual site title
     * @var
     */
    private $pageTitle;

    /**
     *Set base parameters.
     */
    function __construct()
    {
        parent::__construct();

        $this->siteTitle = SITE_TITLE." ";

        $url = Application::generateUrl();

        $domain = explode("/",SITE_PATH);
        $domain = array_filter($domain, 'strlen');
            if(count($domain)> 1){
        $this->homeUrl = $url."/".($domain[1] != "admin" ? $domain[1]."/" : "");
            }
            else{
        $this->homeUrl = $url."/";
            }


        self::sessionStart();
        if(isset($_SESSION["title"]))
        $this->siteTitle = SITE_TITLE.$_SESSION["title"];
        else
        $this->siteTitle = SITE_TITLE;
    }

    /**
     *Do nothing.
     */
    function __destruct(){
    parent::__destruct();
    }


    /***Session methods***/

    /**
     * Check if session exist
     * @static
     * @return bool
     */
    public static function session(){
       if(session_id() != null)
           return true;
       else
           return false;
    }

    /**
     * Starting session
     *@static*/
    public static function sessionStart(){
       if(!self::session()){
           session_regenerate_id(true);
           session_start();
       }
    }

    /**
     * Stop session
     *@static*/
    public static function sessionStop(){
            foreach($_SESSION as $key=>$value){
            unset($_SESSION[$key]);
        }
            session_destroy();
    }


    /**
     * Write session
     * @static
     */
    public static function sessionWrite(){
        session_write_close();
    }

    /**
     * Adding variable to session
     * @static
     * @param array $var | Object $var
     * @throws Exception if variable is bad type*/
    public static function addToSession($var){
       self::sessionStart();
       if(is_array($var)){
            foreach($var as $key => $value){
                $_SESSION[$key] = $value;
            }
        }
       else if(is_object($var)){
           $_SESSION[Application::modelName($var)] = $var;
       }
        else
          throw new Exception("Error with adding $$var to session. Check type!");

    }

   /**
    * Removing variable from session
    * @static
    * @param array $var | Object $var
    * @throws Exception if variable is bad type*/
    public static function removeFromSession($var){
       self::sessionStart();
       if(is_array($var)){
            foreach($var as $key => $value){
                unset($_SESSION[$key]);
            }
        }
        else if(is_object($var)){
            unset($_SESSION[Application::modelName($var)]);
        }
        else{
            throw new Exception("Error with removing $$var from session. Check type!");
        }
    }

    /*** Model Object Session Methods ***/

   /**
    * Add model object to session array
    * @static
    * @param Object $obj
    * @throws Exception if variable is bad type*/
    public static function sendSessionModel($obj){
        self::sessionStart();
        if(is_object($obj))
            $_SESSION[Application::modelName($obj)] = $obj;
        else{
            throw new Exception("Error with adding model $$obj to session. Check type!");
        }
    }

  /**
   * Removing model object from session array
   * @static
   * @param Object $obj
   * @throws Exception if variable is bad type*/
    public static function removeSessionModel($obj){
        self::sessionStart();
        if(is_object($obj))
            unset($_SESSION[Application::modelName($obj)]);
        else{
            throw new Exception("Error removing model $$obj from session. Check type!");
        }
    }

   /**
    * Get model object from session array
    * @static
    * @param Object $obj
    * @return Object $obj
    * @throws Exception if variable is bad type*/
    public static function getSessionModel($obj){
        self::sessionStart();
        if(is_object($obj))
            return $_SESSION[Application::modelName($obj)];
        else{
            throw new Exception("Error getting model $$obj from session. Check type!");
        }
    }

    /*** Model Object Get Methods ***/

   /**
    * Add model object to Get array
    * @static
    * @param Object $obj
    * @throws Exception if variable is bad type*/
    public static function sendGetModel($obj){
        if(is_object($obj))
        $_GET[Application::modelName($obj)] = $obj;
        else{
            throw new Exception("Error with adding model $$obj to get. Check type!");
        }
    }

   /**
    * Get model object from Get array
    * @static
    * @param Object $obj
    * @return Object $obj
    * @throws Exception if variable is bad type*/
    public static function getGetModel($obj){
        if(is_object($obj))
            return $_GET[Application::modelName($obj)];
        else{
            throw new Exception("Error getting model $$obj from get. Check type!");
        }
    }

   /**
    * Removing model object from Get array
    * @static
    * @param Object $obj
    * @throws Exception if variable is bad type*/
    public static function removeGetModel($obj){
        if(is_object($obj))
            unset($_GET[Application::modelName($obj)]);
        else{
            throw new Exception("Error removing model $$obj from get. Check type!");
        }
    }

    /*** Model Object Post Methods ***/

   /**
    * Get model object from Post array
    * @static
    * @param Object $obj
    * @return Object $obj
    * @throws Exception if variable is bad type*/
    public static function getPostModel($obj){
        if(is_object($obj))
        return $_POST[Application::modelName($obj)];
        else{
            throw new Exception("Error getting model $$obj from post. Check type!");
        }
    }

   /**
    * Add model object to Post array
    * @static
    * @param Object $obj
    * @throws Exception if variable is bad type*/
    public static function sendPostModel($obj){
        if(is_object($obj))
        $_POST[Application::modelName($obj)] = $obj;
        else{
            throw new Exception("Error sending model $$obj to post. Check type!");
        }
    }

   /**
    * Remove model from Post array
    *@param Object $obj
    *@throws Exception if variable is bad type*/
    public function removePostModel($obj){
        if(is_object($obj))
        unset($_GET[Application::modelName($obj)]);
        else{
            throw new Exception("Error removing model $$obj from post. Check type!");
        }
    }

    /*** Model Object Help Methods ***/

    /**
     * Removing from model object word "Model"
     * @static
     * @param Object $obj
     * @return string*/
    public static function modelName($obj){
       $name = get_class($obj);
       return  strtolower($modelName = preg_replace("/Model/","",$name));
    }

    /*** User Identyfication Methods ***/

    /**
     * Check if user is guest
     * @static
     * @return bool*/
    public static function isGuest(){
            self::sessionStart();
            if(isset($_SESSION["user"])){
                 return false;
            }
            else
                return true;
    }

    /**
     * Check if user is Admin
     * @static
     * @return bool*/
    public static function isAdmin(){
        self::sessionStart();
        if($_SESSION["user"] != null){
           $usr = $_SESSION["user"];
           $config = new Configuration();
            if($usr->id_user ==  $config->getAdminId()){
            return true;
            }
            else
               return false;
        }
        else
            return false;
    }

    /**
     * Return logged user object
     * @static
     * @return mixed*/
    public static function loggedUser(){
        self::sessionStart();
        if($_SESSION["user"] != null){
            $usr = $_SESSION["user"];
             return $usr;
        }
        else
            return false;
    }

    /**
     * Check if id is the same as user id from session
     * @static
     * @param int $id
     * @return bool */
    public static function isOwner($id){
        self::sessionStart();
        if($_SESSION["user"] != null){
              $usr = $_SESSION["user"];
            if($id == $usr->id_user){
                return true;
            }
            else
                return false;
        }
        else
            return false;
    }

    /*** Simple error manager ***/

    /**
     * Display errors, warnings, messages.
     *All contains in session*/
    public function error(){
        self::sessionStart();
        if(isset($_SESSION["error"])){
            if($_SESSION["error"]["type"] == 'error'){
                $mesaage = $_SESSION["error"]['message'];
                echo "<div class='error'><p>$mesaage</p></div>";
            }
            else if($_SESSION["error"]["type"] == 'warning'){
                $mesaage = $_SESSION["error"]['message'];
                echo "<div class='warning'><p>$mesaage</p></div>";
            }
            else if($_SESSION["error"]["type"] == 'message'){
                $mesaage = $_SESSION["error"]['message'];
                echo "<div class='message'><p>$mesaage</p></div>";
            }
            unset($_SESSION['error']);
        }
    }

    /*** Helper Methods ***/

    /**
     * Generate actual link and add it to session
     *@static*/
    public static function makeActualLink(){
        self::clearActualLink();
        self::sessionStart();
        $app= new Application();
        $link = $app->getHomeUrl()."index.php?";
        foreach ($_GET as $key => $value){
            $link.=$key."=".$value."&";
        }
        $link  = substr($link,0,-1);
        $_SESSION["link"]= $link;
    }

   /**
    * Return actual link to redirect
    * @static
    * @return string */
    public static function getActualLink(){
        self::sessionStart();
        return $_SESSION["link"];
    }

    /**
     * Clear acutal link from session
     *@static*/
    public  static function clearActualLink(){
        self::sessionStart();
        unset($_SESSION["link"]);
    }

    /**
     * Return dir for load files
     * @static
     * @return string
     */
    public static function getBaseDir()
    {
        return self::$baseDir;
    }

    /**
     * Return template dir
     * @static
     * @return string
     */
    public static function templateDir(){
        $url = Application::generateUrl();
        $configuration = new Configuration();
        return $url.=DIRECTORY_SEPARATOR.SITE_PATH."/templates/".$configuration->getTemplate().DIRECTORY_SEPARATOR;
    }

    /**
     * Check basic URL
     * @static
     * @return string
     */
    private static function generateUrl(){
        $url  ="http://".$_SERVER["SERVER_NAME"];
        if($_SERVER["SERVER_PORT"] != 80){
            $url .=":".$_SERVER["SERVER_PORT"];
        }
       return $url;
    }

    /**
     * Return url for homepage
     * @return string
     */
    public function getHomeUrl()
    {
        return $this->homeUrl;
    }

    /**
     * Set page title
     * @param string $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * Return title of page
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set site title
     * @param $siteTitle
     */
    public function setSiteTitle($siteTitle)
    {
        $this->siteTitle = $siteTitle;
    }

    /**
     * Return title of site
     * @return string
     */
    public function getSiteTitle()
    {
        return $this->siteTitle;
    }

}
