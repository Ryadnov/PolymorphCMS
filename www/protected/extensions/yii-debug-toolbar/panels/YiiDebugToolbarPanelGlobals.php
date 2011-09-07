<?php
/**
 * YiiDebugToolbarPanelGlobals class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelGlobals class
 *
 * Description of YiiDebugToolbarPanelGlobals
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @packages YiiDebugToolbar
 * @since 2.2.7
 */
class YiiDebugToolbarPanelGlobals extends YiiDebugToolbarPanel
{
    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return 'Globals';
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return 'Global Variables';
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {}

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->render('globals', array(
            'server' => $_SERVER,
            'cookies' => $_COOKIE,
            'session' => $_SESSION,
            'post' => $_POST,
            'get' => $_GET,
            'files' => $_FILES,
        ));
    }
}
