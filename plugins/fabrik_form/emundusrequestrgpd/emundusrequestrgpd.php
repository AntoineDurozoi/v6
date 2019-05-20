<?php

//First start with information about the Plugin and yourself. For example:
/**
 * @package     Joomla.Plugin
 * @subpackage  Fabrik_form.emundusrequestrgpd
 *
 * @copyright   Copyright
 * @license     License, for example GNU/GPL
 */

//To prevent accessing the document directly, enter this code:
// no direct access
defined('_JEXEC') or die();

include_once(JPATH_BASE.'/components/com_emundus/controllers/messages.php');


class PlgFabrik_FormEmundusrequestrgpd extends plgFabrik_Form {

    public function onAfterProcess()
    {

            $formModel = $this->getModel();

            $token       = JApplicationHelper::getHash(JUserHelper::genRandomPassword());
            $hashedToken = JUserHelper::hashPassword($token);

            $formModel->formData['confirm_token']            = $hashedToken;
            $formModel->formData['confirm_token_created_at'] = JFactory::getDate()->toSql();
            $app = JFactory::getApplication();

            $linkMode = $app->get('force_ssl', 0) == 2 ? 1 : -1;



            switch ($formModel->formData['request_type'][0])
            {
                case 'export':
                    $postUser = [
                        'SITENAME' => $app->get('sitename'),
                        'URL'      => JUri::root(),
                        'TYPEREQUEST' => 'Request Created',
                        'REQUEST'  => 'export',
                        'TOKENURL' => JRoute::link('site', 'index.php?option=com_fabrik&view=form&formid=312&confirm_token=' . $token, false, $linkMode),
                        'FORMURL'  => JRoute::link('site', 'index.php?option=com_fabrik&view=form&formid=312', false, $linkMode),
                        'TOKEN'    => $token
                    ];
                    //$emailSubject = JText::_('COM_PRIVACY_EMAIL_REQUEST_SUBJECT_EXPORT_REQUEST');
                    //$emailBody    = JText::_('COM_PRIVACY_EMAIL_REQUEST_BODY_EXPORT_REQUEST');

                    break;

                case 'remove':
                    $postUser = [
                        'SITENAME' => $app->get('sitename'),
                        'URL'      => JUri::root(),
                        'TYPEREQUEST' => 'Deletion Request',
                        'REQUEST'  => 'remove',
                        'TOKENURL' => JRoute::link('site', 'index.php?option=com_fabrik&view=form&formid=312&confirm_token=' . $token, false, $linkMode),
                        'FORMURL'  => JRoute::link('site', 'index.php?option=com_fabrik&view=form&formid=312', false, $linkMode),
                        'TOKEN'    => $token
                    ];
                    //$emailSubject = JText::_('COM_PRIVACY_EMAIL_REQUEST_SUBJECT_REMOVE_REQUEST');
                    //$emailBody    = JText::_('COM_PRIVACY_EMAIL_REQUEST_BODY_REMOVE_REQUEST');

                    break;

                default:
                    $this->setError(JText::_('COM_PRIVACY_ERROR_UNKNOWN_REQUEST_TYPE'));

                    return false;
            }


            $lbl = 'request_rgpd';
            $lblUser = 'requestuser_rgpd';
            $post = [
                'EMAIL' => $formModel->formData['email'],
            ];



            $coordinatorMail = $this->params->get('emundusdpo_email');

            $c_messages = new EmundusControllerMessages();
            $c_messagesUser = new EmundusControllerMessages();
            $c_messages->sendEmailNoFnum($coordinatorMail, $lbl, $post);
        //var_dump($coordinatorMail,$lbl,$post).die();

            $c_messagesUser->sendEmailNoFnum($formModel->formData['email'],$lblUser,$postUser);
            //$mailer = JFactory::getMailer();
            //$mailer->setSubject($emailSubject);
            //$mailer->setBody($emailBody);
            //$mailer->addRecipient($formModel->formData['email']);

            //$mailResult = $mailer->Send();
            if ($c_messagesUser instanceof JException)
            {
                // JError was already called so we just need to return now
                return false;
            }
            elseif ($c_messagesUser === false)
            {
                $message = $this->setError($c_messagesUser->ErrorInfo);
                $app->redirect(JRoute::_('index.php?option=com_privacy&view=request', false), $message, 'error');
                return false;
            }
            else{
                $app->redirect(JRoute::_(JUri::root()), JText::_('COM_PRIVACY_CREATE_REQUEST_SUCCEEDED'), 'info');
                return true;
            }

            /** @var PrivacyTableRequest $table */
            $table = $this->getTable();

            if (!$table->load($this->getState($this->getName() . '.id')))
            {
                $this->setError($table->getError());

                return false;
            }

            // Log the request's creation
            JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_actionlogs/models', 'ActionlogsModel');

            $message = array(
                'action'       => 'request-created',
                'requesttype'  => $table->request_type,
                'subjectemail' => $table->email,
                'id'           => $table->id,
                'itemlink'     => 'index.php?option=com_privacy&view=request&id=' . $table->id,
            );

            /** @var ActionlogsModelActionlog $model */
            $model = JModelLegacy::getInstance('Actionlog', 'ActionlogsModel');
            $model->addLog(array($message), 'COM_PRIVACY_ACTION_LOG_CREATED_REQUEST', 'com_privacy.request');

            // The email sent and the record is saved, everything is good to go from here
            $app->redirect(JRoute::_('index.php'));
            return true;


    }
    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string $name The table name. Optional.
     * @param   string $prefix The class prefix. Optional.
     * @param   array $options Configuration array for model. Optional.
     *
     * @return  JTable  A JTable object
     *
     * @since   3.9.0
     * @throws  \Exception
     */
    public function getTable($name = 'Request', $prefix = 'PrivacyTable', $options = array())
    {
        return parent::getTable($name, $prefix, $options);
    }
}
