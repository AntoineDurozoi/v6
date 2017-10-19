<?php
/**
 * Created by eMundus.
 * User: brivalland
 * Date: 23/05/14
 * Time: 11:39
 * @package        Joomla
 * @subpackage    eMundus
 * @link        http://www.emundus.fr
 * @copyright    Copyright (C) 2006 eMundus. All rights reserved.
 * @license        GNU/GPL
 * @author        Benjamin Rivalland
 */

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );
//error_reporting(E_ALL);
jimport( 'joomla.application.component.view');
/**
 * HTML View class for the Emundus Component
 *
 * @package    Emundus
 */

class EmundusViewFiles extends JViewLegacy
{
	//protected $itemId;
	protected $actions;

	public function __construct($config = array())
	{
		require_once (JPATH_COMPONENT.DS.'helpers'.DS.'list.php');
		require_once (JPATH_COMPONENT.DS.'helpers'.DS.'emails.php');
		require_once (JPATH_COMPONENT.DS.'helpers'.DS.'export.php');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'users.php');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'evaluation.php');

		parent::__construct($config);
	}

    public function display($tpl = null)
    {

    	$current_user = JFactory::getUser();

		if( !EmundusHelperAccess::asPartnerAccessLevel($current_user->id) )
			die( JText::_('RESTRICTED_ACCESS') );

	   	$app = JFactory::getApplication();
		$params = JComponentHelper::getParams('com_emundus');
		//$default_actions = $params->get('default_actions', 0);

	    $this->itemId = $app->input->getInt('Itemid', null);
	    $this->cfnum = $app->input->getString('cfnum', null);
	    $layout = $app->input->getString('layout', null);

		$model 			= $this->getModel('Files');
		$m_evaluation 	= new EmundusModelEvaluation;

	    @EmundusHelperFiles::setMenuFilter();

		switch  ($layout)
		{
			// get access list for application file
			case 'access':
				$fnums = $app->input->getString('users', null);
				$fnums_obj = (array) json_decode(stripslashes($fnums));

			    if(@$fnums_obj[0] == 'all')
					$fnums = $model->getAllFnums();
			    else {
			        $fnums = array();
			        foreach ($fnums_obj as $key => $value) {
			        	$fnums[] = @$value->fnum;
			        }
			    }

			    $groupFnum = $model->getGroupsByFnums($fnums);
			    $evalFnum = $model->getAssessorsByFnums($fnums);
				$users = $model->getFnumsInfos($fnums);
			    $evalGroups = $model->getEvalGroups();
			    $actions = $model->getAllActions();
			    $actions_evaluators = json_decode($default_actions);

			    $this->assignRef('groups', $evalGroups['groups']);
			    $this->assignRef('groupFnum', $groupFnum);
			    $this->assignRef('evalFnum', $evalFnum);
			    $this->assignRef('users', $users);
			    $this->assignRef('evals', $evalGroups['users']);
			    $this->assignRef('actions', $actions);
			    $this->assignRef('actions_evaluators', $actions_evaluators);
			break;
			// get Menu actions
			case 'menuactions':
				$fnum = $app->input->getString("fnum", "0");
				$display = $app->input->getString('display', 'none');
				$menu = @JSite::getMenu();
				$current_menu = $menu->getActive();
				if (isset($current_menu) && !empty($current_menu)) {
					$params = $menu->getParams($current_menu->id);

					if ($fnum === "0")
						$items = @EmundusHelperFiles::getMenuList($params);
					else
						$items = @EmundusHelperFiles::getMenuList($params, $fnum);

					$this->assignRef('items', $items);
					$this->assignRef('display', $display);
				} else {
					echo JText::_('ERROR_MENU_ID_NOT_FOUND');
					return false;
				}
			break;

			case 'filters':
                $m_user = new EmundusModelUsers();

                $model->code = $m_user->getUserGroupsProgrammeAssoc($current_user->id);

                // get all fnums manually associated to user
		        $groups = $m_user->getUserGroups($current_user->id, 'Column');
        		$fnum_assoc_to_groups = $m_user->getApplicationsAssocToGroups($groups);
		        $fnum_assoc = $m_user->getApplicantsAssoc($current_user->id);
		        $model->fnum_assoc = array_merge($fnum_assoc_to_groups, $fnum_assoc);

                $this->assignRef('code', $model->code);
                $this->assignRef('fnum_assoc', $model->fnum_assoc);

				// reset filter
			    $filters = @EmundusHelperFiles::resetFilter();
			    $this->assignRef('filters', $filters);
			break;

			case 'docs':
				$fnumsObj = $app->input->getString('fnums', "");
				$fnumsObj = json_decode(stripslashes($fnumsObj));
				$fnums = array();
				foreach($fnumsObj as $fObj)
				{
					if(EmundusHelperAccess::asAccessAction(27, 'c', JFactory::getUser()->id, $fObj->fnum))
					{
						$fnums[] = $fObj->fnum;
					}
				}
				if(!empty($fnums))
				{
					$prgs = $model->getProgByFnums($fnums);
					$docs = $model->getDocsByProg(key($prgs));
				}
				else
				{
					echo JText::_('ACCESS_DENIED');
					exit();
				}

				$this->assignRef('docs', $docs);
				$this->assignRef('prgs', $prgs);
				$fnums_array = implode(',', $fnums);
				$this->assignRef('fnums', $fnums_array);

			break;
			// get list of application files
			default :
			    $menu = $app->getMenu();
			    $current_menu  = $menu->getActive();
				$menu_params = $menu->getParams($current_menu->id);

				$columnSupl = explode(',', $menu_params->get('em_other_columns'));

				$m_user = new EmundusModelUsers();
				$h_files = new EmundushelperFiles();

                $model->code = $m_user->getUserGroupsProgrammeAssoc($current_user->id);

		        // get all fnums manually associated to user
		        $groups = $m_user->getUserGroups($current_user->id, 'Column');
        		$fnum_assoc_to_groups = $m_user->getApplicationsAssocToGroups($groups);
		        $fnum_assoc = $m_user->getApplicantsAssoc($current_user->id);
		        $model->fnum_assoc = array_merge($fnum_assoc_to_groups, $fnum_assoc);

                $this->assignRef('code', $model->code);
                $this->assignRef('fnum_assoc', $model->fnum_assoc);

			    // get applications files
				$users = $this->get('Users');

				// Get elements from model and proccess them to get an easy to use array containing the element type
				$elements = $model->getElementsVar();
				foreach ($elements as $elt) {
					$elt_name = $elt->tab_name."___".$elt->element_name;
					$eltarr[$elt_name] = [
						"plugin" 	=> $elt->element_plugin,
						"tab_name" 	=> $elt->tab_name,
						"params"  	=> $elt->element_attribs,
						"fabrik_id" => $elt->id
					];
				}

				if (isset($eltarr))
					$elements = $eltarr;


				// Do not display photos unless specified in params
				$displayPhoto = false;

			    $defaultElements = $this->get('DefaultElements');
			    $data = array(array('check' => '#', 'name' => JText::_('APPLICATION_FILES'), 'status' => JText::_('STATUS')));
			    $fl = array();
			    $model = $this->getModel('Files');
			    if (count($defaultElements)>0) {
				    foreach ($defaultElements as $key => $elt)
				    {
					    $fl[$elt->tab_name . '___' . $elt->element_name] = $elt->element_label;
				    }
			    }

			    $data[0] = array_merge($data[0], $fl);
				$fnumArray = array();
			    if(!empty($users))
			    {
				    $i = 1;
                    $taggedFile = array();
				    foreach($columnSupl as $col)
				    {
					    $col = explode('.', $col);
					    switch ($col[0])
					    {
						    case 'evaluators':
							    $data[0]['EVALUATORS'] = JText::_('EVALUATORS');
							    $colsSup['evaluators'] = $h_files->createEvaluatorList($col[1], $model);
							    break;
							case 'overall':
								$data[0]['overall'] = JText::_('EVALUATION_OVERALL');
								break;
                            case 'tags':
                                $taggedFile = $model->getTaggedFile();
                                $data[0]['eta.id_tag'] = JText::_('TAGS');
                                $colsSup['id_tag'] = array();
                                break;
                            case 'access':
                                $data[0]['access'] = JText::_('COM_EMUNDUS_ASSOCIATED_TO');
                                $colsSup['access'] = array();
                                break;
                            case 'photos':
                                $displayPhoto = true;
                                break;
					    }
				    }
				/*	$hasAccess = false;
				    if(EmundusHelperAccess::asAccessAction(11, 'r', JFactory::getUser()->id))
				    {
					    $hasAccess = true;
					    $data[0]['access'] = JText::_("COM_EMUNDUS_ASSOCIATED_TO");
				    }
*/
				    foreach ($users as $user)
				    {
					    $usObj = new stdClass();
					    $usObj->val = 'X';
					    $fnumArray[] = $user['fnum'];
					    $line = array('check' => $usObj);
					    if(array_key_exists($user['fnum'], $taggedFile))
					    {
						    $class = $taggedFile[$user['fnum']]['class'];
						    $usObj->class = $taggedFile[$user['fnum']]['class'];
					    }
					    else
					    {
						    $class = null;
						    $usObj->class = null;

					    }
					    foreach ($user as  $key => $value)
					    {
						    $userObj = new stdClass();

						    if ($key == 'fnum') {
							    $userObj->val = $value;
							    $userObj->class = $class;
								$userObj->type = 'fnum';
								if ($displayPhoto)
									$userObj->photo = $h_files->getPhotos($value);
								$userObj->user = JFactory::getUser((int)substr($value, -7));
								$userObj->user->name = $user['name'];
							    $line['fnum'] = $userObj;
							}

							elseif ($key == 'name' || $key == 'status_class' || $key == 'step' || $key == 'applicant_id' || $key == 'campaign_id')
								continue;

							elseif (isset($elements) && in_array($key, array_keys($elements))) {

								$userObj->val 			= $value;
								$userObj->type 			= $elements[$key]['plugin'];
								$userObj->status_class 	= $user['status_class'];
								$userObj->id 			= $elements[$key]['fabrik_id'];
								$userObj->params 		= $elements[$key]['params'];
								$line[$key] 			= $userObj;

								// Radiobuttons are a strange beast, we need to get all of the values
								if ($userObj->type == 'radiobutton') {
									$params = json_decode($userObj->params);
									$userObj->radio = array_combine($params->sub_options->sub_labels, $params->sub_options->sub_values);
								}


							} else {
							    $userObj->val = $value;
							    $userObj->type = 'text';
                                $userObj->status_class = $user['status_class'];
							    $line[$key] = $userObj;
						    }
					    }
					    if (count(@$colsSup)>0)
					    {
						    foreach($colsSup as $key => $obj)
						    {
							    $userObj = new stdClass();
							    if (!is_null($obj))
							    {
								    if(array_key_exists($user['fnum'], $obj))
								    {
									    $userObj->val = $obj[$user['fnum']];
									    $userObj->type = 'html';
									    $userObj->fnum = $user['fnum'];
									    $line[JText::_(strtoupper($key))] = $userObj;
								    }
								    else
								    {
									    $userObj->val = '';
									    $userObj->type = 'html';
									    $line[$key] = $userObj;
								    }
							    }
								elseif ($key === 'overall' || $key === 'id_tag' || $key === 'access') $line[$key] = "";
						    }
					    }
					   /* if($hasAccess)
					    {
						    $line['access'] = "";
					    }*/
					    $data[$line['fnum']->val.'-'.$i] = $line;
					    $i++;
					}

					if(isset($colsSup['overall']))
					{
						//$colsSup['overall'] = $m_evaluation->getEvaluationAverageByFnum($fnumArray);
					}
					if(isset($colsSup['id_tag']))
					{
						$tags = $model->getTagsByFnum($fnumArray);
						$colsSup['id_tag'] = $h_files->createTagsList($tags);
					}

                    if(isset($colsSup['access']))
				    {
					    $objAccess = $model->getAccessorByFnums($fnumArray);
				    }
                  //var_dump($fnumArray);echo '<hr>';
			    }
			    else
			    {
				    $data = JText::_('NO_RESULT');
			    }

			    /* Get the values from the state object that were inserted in the model's construct function */
			    $lists['order_dir'] = JFactory::getSession()->get( 'filter_order_Dir' );
			    $lists['order']     = JFactory::getSession()->get( 'filter_order' );
			    $this->assignRef('lists', $lists);
			    $this->assignRef('actions', $actions);
			    $pagination = $this->get('Pagination');
			    $this->assignRef('pagination', $pagination);
			    $this->assignRef('users', $users);
			    $this->assignRef('datas', $data);

			    $submitForm = EmundusHelperJavascript::onSubmitForm();
				$delayAct = EmundusHelperJavascript::delayAct();
				$this->assignRef('delayAct', $delayAct);
				$this->assignRef('submitForm', $submitForm);
				$this->assignRef('accessObj', $objAccess);
				$this->assignRef('colsSup', $colsSup);
		    break;
	    }

		parent::display($tpl);

	}

}


