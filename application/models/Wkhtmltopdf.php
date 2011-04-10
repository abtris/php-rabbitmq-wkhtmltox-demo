<?php
/**
 * Wrapper for Wkhtmltopdf
 */
class Application_Model_Wkhtmltopdf
{
    /**
     * Command line execute
     */
    const COMMAND = 'wkhtmltopdf';
    /**
     * Proceed
     * @param string $target URL of html page
     * @param string $destination PDF file
     * @param null $options
     * @return void
     */
    public static function proceed($target, $destination, $options = null)
    {
//        $target = escapeshellarg($target);
//        $destination = escapeshellarg($destination);

        $name = str_replace("http://","", $target);
        $name = str_replace(".","-", $name);
        $name .= ".pdf";

        $cmd = self::COMMAND." $target ".$destination.$name;
        echo "\nCMD: $cmd ". "\n";
        system($cmd);
    }
}

