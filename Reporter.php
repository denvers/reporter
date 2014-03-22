<?php namespace denvers;

require_once( dirname(__FILE__) . "/vendor/autoload.php" );


/**
 * Class Reporter
 *
 * @usage Reporter::report("your@emailaddress.com", "Something to remember", "User did something we need to investigate");
 * @usage Reporter::report("your@emailaddress.com", "Something to remember", "User did something we need to investigate", array("variable1", "key" => "variable2"));
 */
class Reporter
{
    /**
     * @param $emailaddress
     * @param $subject
     * @param $message
     * @param array $extra_vars
     */
    public static function report($emailaddress, $subject, $message, array $extra_vars = array())
    {
        $report = Reporter::generateHTMLReport($subject, $message, $extra_vars);

        $mail = new \PHPMailer();
        $mail->isHTML(true);
        $mail->Body = $report;
        $mail->setFrom('Reporter');
        $mail->addAddress($emailaddress);
        $mail->Subject = $subject;
        $mail->send();
    }

    /**
     * @param $title
     * @param $message
     * @param array $extra_vars
     * @return string
     */
    protected static function generateHTMLReport($title, $message, $extra_vars = array())
    {
        $helper = new \Whoops\Util\TemplateHelper;

        $templateFile = Reporter::getResource("views/layout.html.php");
        $cssFile      = Reporter::getResource("css/whoops.base.css");
        $zeptoFile    = Reporter::getResource("js/zepto.min.js");
        $jsFile       = Reporter::getResource("js/whoops.base.js");

        $frames = array();

        // List of variables that will be passed to the layout template.
        $vars = array(
            "page_title" => $title,

            "stylesheet" => file_get_contents($cssFile),
            "zepto"      => file_get_contents($zeptoFile),
            "javascript" => file_get_contents($jsFile),

            // Template paths:
            "header"      => Reporter::getResource("views/header.html.php"),
            "env_details" => Reporter::getResource("views/env_details.html.php"),

            "title"        => $title,
            "name"         => array($title),
            "message"      => $message,
            "frames"       => $frames,
            "has_frames"   => false,
            "tables"      => array()
        );

        if ( count($extra_vars) )
        {
            $vars['tables']['Passed debug data'] = $extra_vars;
        }

        $vars['tables']["Server/Request Data"]   = $_SERVER;
        $vars['tables']["GET Data"]              = $_GET;
        $vars['tables']["POST Data"]             = $_POST;
        $vars['tables']["Files"]                 = $_FILES;
        $vars['tables']["Cookies"]               = $_COOKIE;
        $vars['tables']["Session"]               = isset($_SESSION) ? $_SESSION:  array();
        $vars['tables']["Environment Variables"] = $_ENV;

        $helper->setVariables($vars);

        // Catch the rendered template and return him
        // @todo let the render()-method return the rendered template
        ob_start();
        $helper->render($templateFile);
        $template = ob_get_contents();
        ob_end_clean();

        return $template;
    }

    /**
     * Finds a resource, by its relative path, in all available search paths.
     * The search is performed starting at the last search path, and all the
     * way back to the first, enabling a cascading-type system of overrides
     * for all resources.
     *
     * @throws RuntimeException If resource cannot be found in any of the available paths
     *
     * @param  string $resource
     * @return string
    */
    protected static function getResource($resource)
    {
        $resourcePath = __DIR__ . "/Resources";

        $fullPath = $resourcePath . "/$resource";

        if(is_file($fullPath)) {
            return $fullPath;
        }

        // If we got this far, nothing was found.
        throw new \RuntimeException(
            "Could not find resource '$resource' in any resource paths."
            . "(searched: " . $resourcePath . ")"
        );
    }
}