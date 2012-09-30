<?php
/**
 * Class handling errors.
 */
/**
 * Class handling errors.
 * @package core
 * @subpackage error
 */
class Error
{
    /**
     * Function display errors
     * @param $error_level
     * @param $error_message
     * @param $error_file
     * @param $error_line
     * @param $error_context
     * @return bool
     */
    public static function errorFunction($error_level, $error_message, $error_file, $error_line, $error_context)
    {
        Logger::log($error_level, $error_message, $error_file, $error_line);

        if (!(error_reporting() & $error_level)) {
            $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
            $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
            $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
            $contents .= "Error on line $error_line in file $error_file";
            $contents .= "</div></div> ";
            echo $contents;
            return;
        }
        switch ($error_level) {
            case E_ERROR:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Error on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;
            case E_WARNING:
                $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Warning on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                break;
            case E_PARSE:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Parse on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;
            case E_NOTICE:
                $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Notice on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                break;
            case E_CORE_ERROR:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Error on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;
            case E_CORE_WARNING:
                $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Warning on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                break;
            case E_USER_ERROR:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Error on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;

            case E_USER_WARNING:
                $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Warning on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                break;

            case E_USER_NOTICE:
                $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Notice on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                break;

            case E_STRICT:
                $contents = "<div class='system_warning' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Notice on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                break;
            case E_RECOVERABLE_ERROR:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Fatal error on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;
            case E_ALL:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>[$error_level] $error_message</strong><br />\n";
                $contents .= "Fatal error on line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;
            default:
                $contents = "<div class='system_error' style='width: 100%; text-align: center'>";
                $contents .= "<div style='width: 90%; background-color: #FEEFB3; border: 1px solid; padding:15px 10px 15px 50px; color: #9F6000; text-align: left; margin: 20px auto;'>";
                $contents .= "<strong>Unknown $error_message</strong><br />\n";
                $contents .= "On line $error_line in file $error_file";
                $contents .= "</div></div> ";
                echo $contents;
                exit(1);
                break;
        }
        return true;
    }

    /**
     * Function display exceptions
     * @param $exception
     */
    public static function errorMessage($exception)
    {
        Logger::log("Exception", $exception->getMessage(), $exception->getFile(), $exception->getLine());
        $errorMsg = "<div class='system_error' style='width: 100%; text-align: center'>";
        $errorMsg .= "<div style='width: 90%; background-color: #FFBABA; border: 1px solid; padding:15px 10px 15px 50px; color: #D8000C; text-align: left; margin: 20px auto;'>";
        $errorMsg .= 'Error on line ' . $exception->getLine() . ' in ' . $exception->getFile()
            . ': <br /><strong>' . $exception->getMessage() . '</strong>';
        $errorMsg .= "</div></div> ";
        echo $errorMsg;
    }


}
