<?php
/**
 * @version		$Id: emundus_period.php 10709 2016-04-07 09:58:52Z emundus.fr $
 * @package		Joomla
 * @copyright	Copyright (C) 2016 emundus.fr. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * emundus_period candidature periode check
 *
 * @package		Joomla
 * @subpackage	System
 */
class  plgSystemEmundus_period extends JPlugin
{
    /**
     * Constructor
     *
     * For php4 compatability we must not use the __constructor as a constructor for plugins
     * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
     * This causes problems with cross-referencing necessary for the observer design pattern.
     *
     * @access	protected
     * @param	object $subject The object to observe
     * @param 	array  $config  An array that holds the plugin configuration
     * @since	1.0
     */
    function plgSystemEmundus_period(& $subject, $config)
    {
        parent::__construct($subject, $config);
        $this->loadLanguage( );
    }

    /**
     * Gets object of connections
     *
     * @return  array  of connection tables id, description
     */
    public function getConnections($description)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*, id AS value, description AS text')->from('#__fabrik_connections')->where('published = 1 and description like "'.$description.'"');
        $db->setQuery($query);
        $connections = $db->loadObjectList();

        foreach ($connections as &$cnn)
        {
            $this->decryptPw($cnn);
        }

        return $connections;
    }

    /**
     * Decrypt once a connection password - if its params->encryptedPw option is true
     *
     * @param   JTable  &FabrikTableConnection  Connection
     *
     * @since   3.1rc1
     *
     * @return  void
     */
    protected function decryptPw(&$cnn)
    {
        if (isset($cnn->decrypted) && $cnn->decrypted)
        {
            return;
        }

        $crypt = EmundusHelperAccess::getCrypt();
        $params = json_decode($cnn->params);

        if (is_object($params) && $params->encryptedPw == true)
        {
            $cnn->password = $crypt->decrypt($cnn->password);
            $cnn->decrypted = true;
        }
    }


    function onAfterInitialise() {
        include_once(JPATH_SITE.'/components/com_emundus/helpers/access.php');

        $app 		=  JFactory::getApplication();
        $user 		=  JFactory::getUser();

        $eMConfig = JComponentHelper::getParams('com_emundus');
        $applicant_files_path = $eMConfig->get('applicant_files_path', 'images/emundus/files/');
        
        // Global variables
        define('EMUNDUS_PATH_ABS', JPATH_ROOT.DS.$applicant_files_path);
        define('EMUNDUS_PATH_REL', $applicant_files_path);
        define('EMUNDUS_PHOTO_AID', 10);

/************ AMETYS INTEGRATION ****///////////////////////
        if ( !$app->isAdmin() ) {
            $ametys_integration = $eMConfig->get('ametys_integration', 0);
            $ametys_url = $eMConfig->get('ametys_url', '');

            if ($ametys_integration == 1 && $user->guest && !empty($ametys_url)) {
                $jinput = $app->input;
                $token = $jinput->get('token');

                if(!empty($token)){
                    // @TODO :
                    // Construct the DB connexion to Ametys local DB
                    $conn = $this->getConnections('ametys');
                    $option = array(); //prevent problems

                    $option['driver']   = 'mysql';              // Database driver name
                    $option['host']     = $conn[0]->host;         // Database host name
                    $option['user']     = $conn[0]->user;         // User for database authentication
                    $option['password'] = $conn[0]->password;     // Password for database authentication
                    $option['database'] = $conn[0]->database;      // Database name
                    $option['prefix']   = '';                    // Database prefix (may be empty)

                    $db_ext = JDatabaseDriver::getInstance( $option );

// 1. select user data from Ametyd BDD
                    $query = 'SELECT *
                                FROM Users_CandidateToken as uct
                                LEFT JOIN  Users as u on u.email=uct.login
                                WHERE uct.token like "'.$token.'"';
                    $db_ext->setQuery( $query );
                    $user_tmp = $db_ext->loadAssoc();

                    if (count($user_tmp) > 0) {
// 2. check if user exist in emundus BDD
                        $db =  JFactory::getDBO();

                        $query = 'SELECT *
                                FROM #_users
                                WHERE email like "'.$user_tmp['login'].'"';
                        $db->setQuery( $query );
                        $user_joomla = $db->loadObject();

                        if($result->id) {
// 2.1 if user exist in emundus then login
                            $jUser = JFactory::getUser($result->id);
                            //$userarray = array();
                            //$userarray['username'] = $jUser->username;
                            //$userarray['password'] = $jUser->password;
                            //$app->login($userarray);              

                            $instance = $jUser;     
                            $instance->set('guest', 0);

                            // Register the needed session variables

                            $session->set('user', $jUser);


                            // Check to see the the session already exists.                        
                            $app->checkSession();

                            // Update the user related fields for the Joomla sessions table.
                            $db->setQuery(
                                    'UPDATE '.$db->nameQuote('#__session') .
                                    ' SET '.$db->nameQuote('guest').' = '.$db->quote($instance->get('guest')).',' .
                                    '   '.$db->nameQuote('username').' = '.$db->quote($instance->get('username')).',' .
                                    '   '.$db->nameQuote('userid').' = '.(int) $instance->get('id') .
                                    ' WHERE '.$db->nameQuote('session_id').' = '.$db->quote($session->getId())
                            );
                            $db->query();

                            // Hit the user last visit field
                            $instance->setLastVisit();          

                            //return true;

                            $app->redirect('index.php');
                    }

                    else {
                // 2.2 else create user and login
                        break;
                        }
                    } else {
                        $app->redirect( $ametys_url );
                    }         
                } else {
                    $app->redirect( $ametys_url );
                }
            }
        }
 ////////////////////////////////////////////////////////////////////////////////////////////



        if ( !$app->isAdmin() && isset($user->id) && !empty($user->id) && EmundusHelperAccess::isApplicant($user->id) ) {
     
            $id_applicants 	= $eMConfig->get('id_applicants', '0');
            $applicants 	= explode(',', $id_applicants);
            $r 				= JRequest::getVar('r', null, 'GET', 'none',0);

            $baseurl = JURI::base();
            
            $app = JFactory::getApplication();

            $id = JRequest::getVar('id', null, 'GET', 'none',0);
            $option = JRequest::getVar('option', null, 'GET', 'none',0);
            $task = JRequest::getVar('task', null, 'POST', 'none',0);
            $task_get = JRequest::getVar('task', null, 'GET', 'none',0);
            $view =JRequest::getVar('view', null, 'GET', 'none',0);

            $no_profile = (empty($user->profile) || !isset($user->profile))?1:0;
            if ($no_profile) $user->applicant = 1;
            if ( $r != 1 && $user->applicant==1 && !in_array($user->id, $applicants) ) {
                if($no_profile && $task != "user.logout" && $task_get != "cancel_renew"  && $task_get != "openfile" && $option != 'com_users' && $option != 'com_content') {
                    die($app->redirect("index.php?option=com_fabrik&view=form&formid=102&random=0&r=1"));
                }
            }
        }
    }
}
