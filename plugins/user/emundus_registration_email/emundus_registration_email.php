<?php

/**
 * @package Registration Email
 * @author Hugo Moracchini
 * @copyright Copyright (c)2018 eMundus SA
 * @license GNU General Public License version 2, or later
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted access');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class plgUserEmundus_registration_email extends JPlugin {

	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @param  object $subject The object to observe
	 * @param  array  $config  An array that holds the plugin configuration
	 *
	 * @since  3.9.1
	 * @throws Exception
	 */
	public function __construct(&$subject, $config) {

		parent::__construct($subject, $config);
		$this->loadLanguage();
		 if (JRequest::getInt('emailactivation')) {
			$userId = JRequest::getInt('u');
			$app    = JFactory::getApplication();
			$user   = JFactory::getUser($userId);

			if (!$user->guest) {

				// need to load fresh instance
				$table = JTable::getInstance('user', 'JTable');
				$table->load($userId);

				if (empty($table->id)) {
					throw new Exception('User cannot be found');
				}

				$params = new JRegistry($table->params);

				// get token from user parameters
				$token = $params->get('emailactivation_token');
				$token = md5($token);

				$redirect = $this->params->get('activation_redirect');

				// Check that the token is in a valid format.
				if (!empty($token) && strlen($token) === 32 && JRequest::getInt($token, 0, 'get') === 1) {

					// Remove token and from user params.
					$params->set('emailactivation_token', null);
					$table->params = $params->toString();

					// Unblock the user :)
					$table->block = 0;

					// save user data
					if ($table->store()) {
						$app->enqueueMessage(JText::_('PLG_EMUNDUS_REGISTRATION_EMAIL_ACTIVATED'),'success');
					} else {
						throw new RuntimeException($table->getError());
					}

				} elseif ($table->block == 0) {
					$app->enqueueMessage(JText::_('PLG_EMUNDUS_REGISTRATION_EMAIL_ALREADY_ACTIVATED'), 'warning');
				} else {
					$app->enqueueMessage(JText::_('PLG_EMUNDUS_REGISTRATION_EMAIL_ERROR_ACTIVATED'), 'error');
				}

				if (!empty($redirect)) {
					$app->redirect($redirect);
				}
			}
		}
	}

	/**
	 * Call our custom plugin event after the user is saved.
	 * @since 3.9.1
	 *
	 * @param $user
	 * @param $isnew
	 * @param $result
	 * @param $error
	 *
	 * @throws Exception
	 */
	public function onUserAfterSave($user, $isnew, $result, $error) {
		$this->onAfterStoreUser($user, $isnew, $result, $error);
	}


	/**
	 * Once a new user is created, add the activation email token in his params.
	 * @since 3.9.1
	 *
	 * @param $new
	 * @param $isnew
	 * @param $result
	 * @param $error
	 *
	 * @throws Exception
	 */
	public function onAfterStoreUser($new, $isnew, $result, $error) {
		$userId = (int) $new['id'];
		$user = JFactory::getUser($userId);

		if (!$isnew || !JFactory::getUser()->guest) {
			return;
		}

		// If user is found in the LDAP system.
		if (JPluginHelper::getPlugin('authentication','ldap')) {
			require_once (JPATH_BASE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'users.php');
			$m_users = new EmundusModelusers();
			$return = $m_users->searchLDAP($user->username);

			if (!empty($return->users[0])) {
				return;
			}
		}

		// if saving user's data was successful
		if ($result && !$error) {

			// Generate the activation token.
			$activation = md5(mt_rand());

			// Store token in User's Parameters
			$user->setParam('emailactivation_token', $activation);

			// Get the raw User Parameters
			$params = $user->getParameters();

			// Set the user table instance to include the new token.
			$table = JTable::getInstance('user', 'JTable');
			$table->load($userId);
			$table->params = $params->toString();

			// Block the user (until he activates).
			$table->block = 1;

			// Save user data
			if (!$table->store()) {
				throw new RuntimeException($table->getError());
			}

			// Send activation email
			if ($this->sendActivationEmail($user->getProperties(), $activation)) {

				$app = JFactory::getApplication();
				$app->enqueueMessage(JText::_('PLG_EMUNDUS_REGISTRATION_EMAIL_SENT'),'success');

				// Force user logout
				if ($this->params->get('logout', null) && $userId === (int) JFactory::getUser()->id) {
					$app->logout();
					$app->redirect(JRoute::_(''), false);
				}
			}
		}
	}

	/**
	 * Send activation email to user in order to proof it
	 * @since  3.9.1
	 *
	 * @access private
	 *
	 * @param  array  $data  JUser Properties ($user->getProperties)
	 * @param  string $token Activation token
	 *
	 * @return bool
	 * @throws Exception
	 */
	private function sendActivationEmail($data, $token) {

	    if (json_decode($data['params'])->skip_activation) {
	        return false;
        }

	    $jinput = JFactory::getApplication()->input;
	    $civility = is_array($jinput->post->get('jos_emundus_users___civility')) ? $jinput->post->get('jos_emundus_users___civility')[0] : $jinput->post->get('jos_emundus_users___civility');
	    $password = !empty($data['password_clear']) ? $data['password_clear'] : $jinput->post->get('jos_emundus_users___password');

		require_once (JPATH_BASE.DS.'components'.DS.'com_emundus'.DS.'controllers'.DS.'messages.php');
		$c_messages = new EmundusControllerMessages();

		$userID = (int) $data['id'];
		$baseURL = rtrim(JURI::root(), '/');
		$md5Token = md5($token);

		// Compile the user activated notification mail values.
		$config = JFactory::getConfig();

		// Get a SEF friendly URL or else sites with SEF return 404.
		// WARNING: This requires making a root level menu item in the backoffice going to com_users&task=edit on the slug /activation.
		// TODO: Possibly use JRoute to make this work without needing a menu item?
		if ($config->get('sef') == 0) {
			$activation_url_rel = '/index.php?option=com_users&task=edit&emailactivation=1&u='.$userID.'&'.$md5Token.'=1';
		} else {
			$activation_url_rel = '/activation?emailactivation=1&u='.$userID.'&'.$md5Token.'=1';
		}
		$activation_url = $baseURL.$activation_url_rel;

		$post = [
		    'CIVILITY'      => $civility,
			'USER_NAME'     => $data['name'],
			'USER_EMAIL'    => $data['email'],
			'SITE_NAME'     => $config->get('sitename'),
			'ACTIVATION_URL' => $activation_url,
			'ACTIVATION_URL_REL' => $activation_url_rel,
			'BASE_URL'      => $baseURL,
			'USER_LOGIN'    => $data['username'],
			'USER_PASSWORD' => $password
		];
		
		// Send the email.
		return $c_messages->sendEmailNoFnum($data['email'], $this->params->get('email', 'registration_email'), $post);
	}
}
