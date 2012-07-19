<?php
/**
 * Created by IntelliJ IDEA.
 * User: loki
 * Date: 19.04.12
 * Time: 07:18
 */

/**Class to generate Html code from php vars and arrays */
class HTMLManager implements HTMLInterface
{
    /**
     *
     */
    function __construct()
    {
    }

    function __destruct()
    {
    }

   /**Method make link (<a></a> tag)
    *@param array $array with link values
    *@param bool $admin  if link is to administration sector
    *@return string with correct <a></a> tag */
    public static function makeLink($array = array(), $admin)
    {
        $app = new Application();

        $href ='';
        $parameters ='';
        $link ='';

        if(is_array($array)){
          foreach($array as $key => $value){
              /*Check if is array, if is we make next menu level*/
              if(!is_array($value)){
              switch($key){
                case "id":
                    $parameters .="id='$value' ";
                    break;
                case "class":
                   $parameters .="class='$value' ";
                    break;
                case "target":
                   $parameters .="target='_$value' ";
                    break;
                  case "admin":
                      $admin = $value;
                      break;
                case "href":
                   $href = "href='".$app->getHomeUrl().($admin == false ? "index.php?url=" : "admin/index.php?url=").$value."'";
                    break;
                case "link":
                    $link = $value;
                    break;
              }
                }
              else if(is_array($value)){
                  return HTMLManager::makeMenu($value);
              }
              else{
                  return "Bad variable type.";
              }
          }
          return "<a $href $parameters >$link</a>";
        }
        else
            return "Bad variable type.";
    }

   /**Method make <img /> tag
    *@param array $array with image values
    *@return string */
    public static function makeImage($array = array())
    {
        $app = new Application();
        $src ='';
        $parameters ='';

        if(is_array($array)){
            foreach($array as $key => $value){
                switch($key){
                    case "id":
                        $parameters .="id='$value' ";
                        break;
                    case "class":
                        $parameters .="class='$value' ";
                        break;
                    case "title":
                        $parameters .="title='$value' ";
                        break;
                    case "alt":
                        $parameters .="alt='$value' ";
                        break;
                    case "src":
                        $src = "src='".$app->getHomeUrl().$value."'";
                        break;
                }
            }
            return  "<img".$src.$parameters."/>";
        }
        else
            return "Bad variable type.";
    }

   /**Method clear input varibales, protect for SqlInjection
    *@param string $input
    *@return string */
    public static function cleanInput($input)
    {
      return stripslashes(htmlentities($input)) ;
    }

   /**Method make list menu <ul></ul>
    *@param array $array with link values
    *@param bool $admin  if link is to administration sector
    *@return string with correct <ul><ul> tag */
    public static function makeMenu($array = array(), $admin)
    {
         $variable = "";
         if(is_array($array)){
             $variable .="<ul>\n";
                 foreach($array as $key => $value){
                 /*Don't show empty records*/
                     if(count($value) > 0)
                    $variable .="<li class='item-$key'>\n".HTMLManager::makeLink($value,$admin)."\n</li>\n";
                 }
                    $variable .="</ul>\n";
            return $variable;
         }
            return "Bad variable type.";
    }

   /**Method create <select></select> tag
    *@param array $array with select values
    *@return string with correct <select> tag */
    public static function makeSelect($array = array())
    {
           $id ='';
           $class = '';
           $label = '';
           $options ='';
           $selected = '';
           $name = '';
           $select = '';

            if(is_array($array)){
               foreach($array as $key =>$value){
                     switch($key){
                     case"id":
                         $id = "id='$value'";
                     break;
                     case"class":
                         $class = "class='$value'";
                     break;
                     case"label":
                         $label_id = $array['id'];
                         $label = "<label for ='$label_id'>".$value."</label>";
                     break;
                     case"name":
                         $name = "name ='$value'";
                     break;
                     case "selected":
                         $selected = $value;
                     break;
                     case "values":
                        $options = HTMLManager::makeOptions($value, $selected);
                     break;
                     }
               }

                $select .= ($label != '' ? $label."\n" : '');
                $select .="<select $id $class $name>\n";
                $select .=$options;
                $select .="</select>\n";

                return $select;

            }else
                return "Bad variable type.";
    }

   /**Method create options for select method
    *@param array $array with select values
    *@param bool $selected if option should be selected
    *@return string with correct <option> tag */
    private static function makeOptions($array =array(), $selected)
    {
        $options = '';

        if(is_array($array)){
            foreach($array as $key => $value){
                $select = ($selected == $value? "selected='selected'" : '');
                $options .= "<option $select value='$value'>$key</option>\n";
        }
            return $options;
        }else
            return "Bad variable type.";
    }

}
