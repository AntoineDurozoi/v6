<?php

/**
 * @package   Joomla.Site
 * @subpackage  eMundus
 * @copyright Copyright (C) 2018 emundus.fr. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once (JPATH_BASE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'cifre.php');
$m_cifre = new EmundusModelCifre();

echo $description;
$uri = JUri::getInstance();

$confirm_form_url = $m_application->getConfirmUrl($fnums);
$first_page = $m_application->getFirstPage('index.php', $fnums);
$contacts = modemundusApplicationsHelper::getContactOffers($fnums);
$chat_requests = modemundusApplicationsHelper::getChatRequests(JFactory::getUser()->id);


// Include Iconate in order to animate de favorite icon.
$document = JFactory::getDocument();
$document->addScript('https://cdnjs.cloudflare.com/ajax/libs/iconate/0.3.1/iconate.js');
$document->addStyleSheet('https://cdnjs.cloudflare.com/ajax/libs/iconate/0.3.1/iconate.min.css');
?>

<div class="content">
    <div class="w-container">
        <?php if ($show_add_application && ($position_add_application == 0 || $position_add_application == 2) && $applicant_can_renew) : ?>
            <a class="big-card-add w-inline-block" href="<?= JURI::base(); ?>component/fabrik/form/102">
                <div class="ajouter-sujet"><?= JText::_('ADD_APPLICATION_FILE'); ?></div>
            </a>
        <?php endif; ?>

        <?php if (!empty($applications)) :?>

            <div class="em-hesam-applications w-container">
                <?php foreach ($applications as $application) :?>

                <?php
	                // We need to find out if we have 2 favorites for this .
	                $nb_faves = 0;
	                foreach ($contacts[$application->fnum] as $profile_id => $requests) {
                        if ($requests[0]['favorite']) {
                            $nb_faves++;
                        }
	                }
                ?>

                    <div class="wrapper-big-car" id="row<?= $application->fnum; ?>">

                        <div class="headerbig-card">
                            <div class="div-block-3">
                                <span class="fa fa-user"></span>
                                <div>
                                    <div class="small-explanation">
                                        <?= JText::_('YOUR_OFFER').' - <em>'.$application->value.'</em>'; ?>
                                    </div>
                                    <div class="text-block-2">
                                        <?= (!empty($application->titre))?$application->titre:JText::_('NO_TITLE'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper-edit">
                                <?php if ($application->status === '1' || $application->status === '2') :?>
                                    <span class="fa fa-share-alt" onclick="share('<?= $application->titre; ?>', '<?= addslashes(preg_replace("/\r|\n/", "",(strlen($application->question) >= 150)?substr($application->question, 0, 147).'...':$application->question)); ?>')"></span>
                                <?php endif; ?>

	                            <?php if ($application->status !== '0') :?>
                                    <!-- Edit button -->
                                    <a id="edit" href="<?= JRoute::_(JURI::base().'index.php?option=com_emundus&task=openfile&fnum='.$application->fnum.'&redirect='.base64_encode($first_page[$application->fnum]['link'])); ?>" title="<?= JText::_('OPEN_APPLICATION'); ?>">
                                        <span class="fa fa-edit"></span>
                                    </a>
                                <?php endif; ?>

                                <!-- Trash button -->
                                <a id="trash" onClick="<?= ($application->status !== '1')?'deletefile('.$application->fnum.');':'completefile('.$application->fnum.', true)'; ?>" href="#row<?= $application->fnum; ?>" title="<?= JText::_('DELETE_APPLICATION_FILE'); ?>">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="big-card<?= ($application->status === '0')?'-brouillon':'' ?>">
                            <?php if ($application->status === '0') :?>
                                <p class="paragraph-infos">
                                    <strong><?= JText::_('OFFER_IS_DRAFT'); ?><br>‍</strong>
                                    <span class="text-span-2"><?= JText::_('OFFER_IS_DRAFT_DESCRIPTION'); ?><br></span>
                                </p>
                                <a class="cta-brouillon w-button" href="<?= JRoute::_(JURI::base().'index.php?option=com_emundus&task=openfile&fnum='.$application->fnum.'&redirect='.base64_encode($first_page[$application->fnum]['link'])); ?>"><?= JText::_('OPEN_APPLICATION'); ?></a>
                            <?php else :?>
                                <div class="column-card-container w-row">

                                    <?php if ($nb_faves === 2) :?>
                                        <div class="em-join-icon" onclick="completefile('<?= $application->fnum; ?>', false)">
                                            <span class="fa fa-check"></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($application->profile_id !== '1006') :?>
                                        <div class="w-col w-col-6">

                                            <a href="consultez-les-offres?q=doctorant&fnum=<?= $application->fnum; ?>" class="card-ajouter-these w-inline-block">
                                                <div class="ajouter-sujet"><?= JText::_('SEARCH_DOCTORANT'); ?></div>
                                            </a>

                                            <?php foreach ($contacts[$application->fnum]['1006'] as $contact) :?>
                                                <!-- Futur doc -->
                                                <div class="card w-clearfix" id="card-<?= $contact['link_id']; ?>">

                                                    <!-- Favorite system. -->
	                                                <?php if ($contact['state'] === '2') :?>
                                                        <?php if ($contact['favorite']) :?>
                                                            <i class="fa fa-star em-star-button link-block-3 w-inline-block" id="favorite-<?= $contact['link_id']; ?>" rel="tooltip" title="<?= JText::_('FAVORITE_CLICK_HERE_UNFAV'); ?>" onclick="unfavorite(<?= $contact['link_id']; ?>)"></i>
                                                        <?php else :?>
                                                            <i class="fa fa-star-o em-star-button link-block-3 w-inline-block" rel="tooltip" title="<?= JText::_('FAVORITE_CLICK_HERE'); ?>" onclick="favorite(<?= $contact['link_id']; ?>)"></i>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <div class="headsmallcard"></div>
                                                    <?php
                                                        $cardClass = '';
                                                        if ($contact['state'] === '1') {
                                                            if ($contact['direction'] === '-1') {
                                                                $cardClass = 'pending';
                                                            } elseif ($contact['direction'] === '1') {
                                                                $cardClass = 'demandecontact';
                                                            }
                                                        }
                                                    ?>
                                                    <div class="wrapper-small-card-content <?= $cardClass; ?>">
                                                        <div class="w-row">
                                                            <div class="w-col w-col-8">
                                                                <div class="text-block-2"><?= $contact['titre']; ?></div>
                                                            </div>
                                                            <?php if ($contact['direction'] === '-1' && $contact['state'] === '1') :?>
                                                                <div class="w-col w-col-4">
                                                                    <div class="statuts envoye"><?= JText::_('REQUEST_SENT'); ?></div>
                                                                </div>
                                                            <?php elseif ($contact['direction'] === '1' && $contact['state'] === '1') :?>
                                                                <div class="w-col w-col-4">
                                                                    <div class="statuts recu"><?= JText::_('REQUEST_RECEIVED'); ?></div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="div-block">
                                                            <span class="fa fa-user-graduate"></span>
                                                            <div class="name">
                                                                <?= JFactory::getUser($contact['applicant_id'])->name; ?>
                                                            </div>
                                                        </div>
                                                        <div class="div-block-mail">
                                                            <div class="w-row">
                                                                <div class="w-col w-col-9">
                                                                    <div class="sujet">
                                                                        <?php if ($contact['status'] === 3) :?>
                                                                            <?= JText::_('OFFER_UNPUBLISHED'); ?>
                                                                        <?php elseif (!empty($contact['linked_fnum'])) :?>
                                                                            <a href="consultez-les-offres/details/299/<?= $contact['search_engine_page']; ?>"><?= JText::_('CONSULT_OFFER'); ?></a>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="column-2 w-col w-col-3">
                                                                    <!-- <a href="#" class="link w-inline-block"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9f28c9278d0a09357c1ff9_Twiice%20-%20Plan%20de%20travail%201.svg" alt="" class="image-bell"></a> -->
                                                                    <a href="/index.php?option=com_emundus&view=messages&layout=chat&chatid=<?= $contact['applicant_id']; ?>" class="link w-inline-block"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9ef4871565a65129befc4c_Twiice2-%20Plan%20de%20travail%201.svg" alt="" class="image-mail"></a>
                                                                    <div class="notif <?= ($contact['unread'] == 0)?'_0notif':''; ?>">
                                                                        <div class="notif-number <?= ($contact['unread'] == 0)?'_0notif':''; ?>"><?= $contact['unread']; ?></div>
                                                                    </div>
                                                                    <?php if ($contact['direction'] === '1' && $contact['state'] === '1') :?>
                                                                        <div id="contactButtons-<?= $contact['link_id']; ?>" class="contact-buttons">
                                                                            <div class="accepter" onclick="reply('<?= $contact['link_id']; ?>')"></div>
                                                                            <div class="refuser" onclick="breakUp('<?= $contact['link_id']; ?>')"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($application->profile_id !== '1007') :?>
                                        <div class="w-col w-col-6">

                                            <a href="consultez-les-offres?q=laboratoire&fnum=<?= $application->fnum; ?>" class="card-ajouter-these w-inline-block">
                                                <div class="ajouter-sujet"><?= JText::_('SEARCH_RESEARCH'); ?></div>
                                            </a>

                                            <?php foreach ($contacts[$application->fnum]['1007'] as $contact) :?>
                                                <!-- Équipe de recherche -->
                                                <div class="card w-clearfix" id="card-<?= $contact['link_id']; ?>">

                                                    <!-- Favorite system. -->
	                                                <?php if ($contact['state'] === '2') :?>
                                                        <?php if ($contact['favorite']) :?>
                                                            <i class="fa fa-star em-star-button link-block-3 w-inline-block" id="favorite-<?= $contact['link_id']; ?>" rel="tooltip" title="<?= JText::_('FAVORITE_CLICK_HERE_UNFAV'); ?>" onclick="unfavorite(<?= $contact['link_id']; ?>)"></i>
                                                        <?php else :?>
                                                            <i class="fa fa-star-o em-star-button link-block-3 w-inline-block" rel="tooltip" title="<?= JText::_('FAVORITE_CLICK_HERE'); ?>" onclick="favorite(<?= $contact['link_id']; ?>)"></i>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <div class="headsmallcard"></div>
                                                    <?php
                                                        $cardClass = '';
                                                        if ($contact['state'] === '1') {
                                                            if ($contact['direction'] === '-1') {
                                                                $cardClass = 'pending';
                                                            } elseif ($contact['direction'] === '1') {
                                                                $cardClass = 'demandecontact';
                                                            }
                                                        }
                                                    ?>
                                                    <div class="wrapper-small-card-content <?= $cardClass; ?>">
                                                        <div class="w-row">
                                                            <div class="w-col w-col-8">
                                                                <div class="text-block-2"><?= $contact['titre']; ?></div>
                                                            </div>
                                                            <?php if ($contact['direction'] === '-1' && $contact['state'] === '1') :?>
                                                                <div class="w-col w-col-4">
                                                                    <div class="statuts envoye"><?= JText::_('REQUEST_SENT'); ?></div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="div-block">
                                                            <span class="fa fa-flask"></span>
                                                            <div class="name">
                                                                <?php
                                                                    $lab = $m_cifre->getUserLaboratory($contact['applicant_id']);
                                                                    echo (empty($lab)) ? JFactory::getUser($contact['applicant_id'])->name : $lab->name;
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="div-block-mail">
                                                            <div class="w-row">
                                                                <div class="w-col w-col-9">
                                                                    <div class="sujet">
                                                                        <?php if ($contact['status'] === 3) :?>
                                                                            <?= JText::_('OFFER_UNPUBLISHED'); ?>
                                                                        <?php elseif (!empty($contact['linked_fnum'])) :?>
                                                                            <a href="consultez-les-offres/details/299/<?= $contact['search_engine_page']; ?>"><?= JText::_('CONSULT_OFFER'); ?></a>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="column-2 w-col w-col-3">
                                                                    <!-- <a href="#" class="link w-inline-block"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9f28c9278d0a09357c1ff9_Twiice%20-%20Plan%20de%20travail%201.svg" alt="" class="image-bell"></a> -->
                                                                    <a href="/index.php?option=com_emundus&view=messages&layout=chat&chatid=<?= $contact['applicant_id']; ?>" class="link w-inline-block"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9ef4871565a65129befc4c_Twiice2-%20Plan%20de%20travail%201.svg" alt="" class="image-mail"></a>
                                                                    <div class="notif <?= ($contact['unread'] == 0)?'_0notif':''; ?>">
                                                                        <div class="notif-number <?= ($contact['unread'] == 0)?'_0notif':''; ?>"><?= $contact['unread']; ?></div>
                                                                    </div>
                                                                    <?php if ($contact['direction'] === '1' && $contact['state'] === '1') :?>
                                                                        <div id="contactButtons-<?= $contact['link_id']; ?>" class="contact-buttons">
                                                                            <div class="accepter" onclick="reply('<?= $contact['link_id']; ?>')"></div>
                                                                            <div class="refuser" onclick="breakUp('<?= $contact['link_id']; ?>')"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($application->profile_id !== '1008') :?>
                                        <div class="w-col w-col-6">

                                            <a href="consultez-les-offres?q=collectivite&fnum=<?= $application->fnum; ?>" class="card-ajouter-these w-inline-block">
                                                <div class="ajouter-sujet"><?= JText::_('SEARCH_COLLECTIVITY'); ?></div>
                                            </a>

                                            <?php foreach ($contacts[$application->fnum]['1008'] as $contact) :?>
                                                <!-- Acteur public ou associatif -->
                                                <div class="card w-clearfix" id="card-<?= $contact['link_id']; ?>">

                                                    <?php if ($contact['state'] === '2') :?>
                                                        <!-- Favorite system. -->
                                                        <?php if ($contact['favorite']) :?>
                                                            <i class="fa fa-star em-star-button link-block-3 w-inline-block" id="favorite-<?= $contact['link_id']; ?>" rel="tooltip" title="<?= JText::_('FAVORITE_CLICK_HERE_UNFAV'); ?>" onclick="unfavorite(<?= $contact['link_id']; ?>)"></i>
                                                        <?php else :?>
                                                            <i class="fa fa-star-o em-star-button link-block-3 w-inline-block" rel="tooltip" title="<?= JText::_('FAVORITE_CLICK_HERE'); ?>" onclick="favorite(<?= $contact['link_id']; ?>)"></i>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                    <div class="headsmallcard"></div>
                                                    <?php
                                                        $cardClass = '';
                                                        if ($contact['state'] === '1') {
                                                            if ($contact['direction'] === '-1') {
                                                                $cardClass = 'pending';
                                                            } elseif ($contact['direction'] === '1') {
                                                                $cardClass = 'demandecontact';
                                                            }
                                                        }
                                                    ?>
                                                    <div class="wrapper-small-card-content <?= $cardClass; ?>">
                                                        <div class="w-row">
                                                            <div class="w-col w-col-8">
                                                                <div class="text-block-2"><?= $contact['titre']; ?></div>
                                                            </div>
                                                            <?php if ($contact['direction'] === '-1' && $contact['state'] === '1') :?>
                                                                <div class="w-col w-col-4">
                                                                    <div class="statuts envoye"><?= JText::_('REQUEST_SENT'); ?></div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="div-block">
                                                            <span class="fa fa-public"></span>
                                                            <div class="name">
                                                                <?= $m_cifre->getUserInstitution($contact['applicant_id'])->nom_de_structure; ?>
                                                            </div>
                                                        </div>
                                                        <div class="div-block-mail">
                                                            <div class="w-row">
                                                                <div class="w-col w-col-9">
                                                                    <div class="sujet">
                                                                        <?php if ($contact['status'] === 3) :?>
                                                                            <?= JText::_('OFFER_UNPUBLISHED'); ?>
                                                                        <?php elseif (!empty($contact['linked_fnum'])) :?>
                                                                            <a href="consultez-les-offres/details/299/<?= $contact['search_engine_page']; ?>"><?= JText::_('CONSULT_OFFER'); ?></a>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="column-2 w-col w-col-3">
                                                                    <!-- <a href="#" class="link w-inline-block"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9f28c9278d0a09357c1ff9_Twiice%20-%20Plan%20de%20travail%201.svg" alt="" class="image-bell"></a> -->
                                                                    <a href="/index.php?option=com_emundus&view=messages&layout=chat&chatid=<?= $contact['applicant_id']; ?>" class="link w-inline-block"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9ef4871565a65129befc4c_Twiice2-%20Plan%20de%20travail%201.svg" alt="" class="image-mail"></a>
                                                                    <div class="notif <?= ($contact['unread'] == 0)?'_0notif':''; ?>">
                                                                        <div class="notif-number <?= ($contact['unread'] == 0)?'_0notif':''; ?>"><?= $contact['unread']; ?></div>
                                                                    </div>
                                                                    <?php if ($contact['direction'] === '1' && $contact['state'] === '1') :?>
                                                                        <div id="contactButtons-<?= $contact['link_id']; ?>" class="contact-buttons">
                                                                            <div class="accepter" onclick="reply('<?= $contact['link_id']; ?>')"></div>
                                                                            <div class="refuser" onclick="breakUp('<?= $contact['link_id']; ?>')"></div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach;  ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($chat_requests)) :?>
            <div class="wrapper-big-car relations-card">
                <div class="headerbig-card header-gray">
                    <div class="div-block-3">
                        <span class="fa fa-comments-o"></span>
                        <div class="text-block-2">&nbsp;<?= JText::_('YOUR_RELATIONS'); ?></div>
                    </div>
                </div>
                <div class="big-card">
                    <?php foreach ($chat_requests as $chat_request) :?>
                        <div class="wrapper-big-card" id="card-<?= $chat_request['link_id']; ?>">
                            <div class="card w-clearfix">
                                <a href="#" class="star link-block-3 w-inline-block" data-ix="star"><img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5ea32c2fd949eca178361a94_star.svg" alt="" class="image-8"></a>
                                <div class="headsmallcard"></div>
                                <div class="wrapper-small-card-content <?= ($chat_request['state'] === '1')?'pending':''; ?>">
                                    <div class="w-row">
                                        <div class="w-col w-col-8">
                                            <div class="div-block-3">
                                                <img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5ebbe1db264db9696201c765_5eaad27c076841830de7d513_5e9f6bfa9fb16576de7aa78d_5e9ef4871565a65129befc4c_Twiice2-%20Plan%20de%20travail%201.svg" alt="" class="image-9">
                                                <div>
                                                    <div class="small-explantation">Votre contact - <em><?= ($chat_request['state'] === '1')?JText::_('REQUEST_SENT'):JText::_('ACCEPTED'); ?></em></div>
                                                    <div class="text-block-2"><?= $chat_request['titre']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="column-8 w-col w-col-4"></div>
                                    </div>
                                    <div class="div-block-contact">
                                        <img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9ef4873152d535b204da4b_Twiice%20-%20Plan%20de%20travail%201.svg" alt="" class="image">
                                        <div class="name">
                                            <?= JFactory::getUser($chat_request['applicant_id'])->name; ?>
                                        </div>
                                    </div>
                                    <div class="div-block-mail">
                                        <div class="w-row">
                                            <div class="column-9 w-col w-col-9">
                                                <div class="sujet">
                                                    <a href="consultez-les-offres/details/299/<?= $chat_request['search_engine_page']; ?>"><?= JText::_('CONSULT_OFFER'); ?></a>
                                                </div>
                                            </div>
                                            <div class="column-2 w-col w-col-3">
                                                <!-- TODO: Notifications -->
                                                <a href="/index.php?option=com_emundus&view=messages&layout=chat&chatid=<?= $chat_request['applicant_id']; ?>" class="link w-inline-block">
                                                    <img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5e9ef4871565a65129befc4c_Twiice2-%20Plan%20de%20travail%201.svg" alt="" class="image-mail">
                                                </a>
                                                <div class="notif <?= ($chat_request['unread'] == 0)?'_0notif':''; ?>">
                                                    <div class="notif-number <?= ($chat_request['unread'] == 0)?'_0notif':''; ?>"><?= $chat_request['unread']; ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="contactButtons-<?= $chat_request['link_id']; ?>" onclick="breakUp('<?= $chat_request['link_id']; ?>')">
                                        <img src="https://assets.website-files.com/5e9eea59278d0a02df79f6bd/5ebbe17210aa833dc56beaea_5e9f03ced3a57f18c49bad26_5e9ef4873152d535b204da4b_Twiice%20-%20Plan%20de%20travail%201.svg" alt="" class="image-delete-smallcard">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <?php if ($show_add_application && $position_add_application > 0 && $applicant_can_renew) : ?>
            <a class="big-card-add w-inline-block" href="<?= JURI::base(); ?>component/fabrik/form/102">
                <div class="ajouter-sujet"><?= JText::_('ADD_APPLICATION_FILE'); ?></div>
            </a>
        <?php endif; ?>

    </div>
</div>

<script type="text/javascript">

    function deletefile(fnum) {

        Swal.fire({
            customClass: {
                title: "heading no-dash"
            },
            title: '<?= JText::_('CONFIRM_DELETE_FILE'); ?>',
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: true,
            reverseButtons: true
        }).then(confirm => {
            if (confirm.value) {
                document.location.href = "index.php?option=com_emundus&task=deletefile&fnum="+fnum+"&redirect=<?= base64_encode($uri->getPath()); ?>";
            }
        });
    }

    function completefile(fnum, trash) {

        Swal.fire({
            customClass: {
                title: "heading no-dash"
            },
            title: '<?= JText::_('CONFIRM_COMPLETE_FILE'); ?>',
            html: (trash ? '<a href="index.php?option=com_emundus&task=deletefile&fnum='+fnum+'&redirect=<?= base64_encode($uri->getPath()); ?>" class="cta-offre w-inline-block"><?= JText::_('DELETE_FILE'); ?></a>':'') +
                '<a href="index.php?option=com_emundus&task=completefile&status=2&fnum='+fnum+'&redirect=<?= base64_encode($uri->getPath()); ?>" class="cta-offre w-inline-block"><?= JText::_('FILE_BOOKED_WITH_HESAM'); ?></a>' +
                '<a href="index.php?option=com_emundus&task=completefile&status=5&fnum='+fnum+'&redirect=<?= base64_encode($uri->getPath()); ?>" class="cta-offre w-inline-block"><?= JText::_('FILE_BOOKED_WITH_HESAM'); ?></a>',
            icon: 'warning',
            showConfirmButton: false,
            showCloseButton: true
        });
    }

    function reply(id) {

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'index.php?option=com_emundus&controller=cifre&task=replybyid',
            data: { id : id },
            beforeSend: () => {
                document.getElementById('contactButtons-'+id).innerHTML = '...';
            },
            success: result => {
                if (result.status) {
                    // When we successfully change the status, we simply dynamically change the button.
                    document.getElementById('contactButtons-'+id).outerHTML = '';
                    Swal.fire({
                        icon: 'success',
                        text: '<?= JText::_('OFFER_ACCEPTED'); ?>'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: result.msg
                    });
                }
            },
            error: jqXHR => {
                console.log(jqXHR.responseText);
            }
        });
    }

    /**
     *
     * @param id
     */
    function breakUp(id) {

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'index.php?option=com_emundus&controller=cifre&task=breakupbyid&action=ignore',
            data: { id : id },
            beforeSend: () => {
                document.getElementById('contactButtons-'+id).innerHTML = '...';
            },
            success: result => {
                if (result.status) {
                    // Dynamically change the button back to the state of not having a link.
                    document.getElementById('card-'+id).outerHTML = '';
                } else {
                    Swal.fire({
                        icon: 'error',
                        text: result.msg
                    });
                }
            },
            error: jqXHR => {
                console.log(jqXHR.responseText);
            }
        });
    }

    /**
     *
     * @param name
     * @param desc
     */
    function share(name, desc) {

        const addressed = '\n Addressée ' +
            '<?= ($application->profile_id !== '1006')?' aux futurs doctorants':''; ?>' +
            '<?= ($application->profile_id !== '1006' && $application->profile_id !== '1007')?'et ':''; ?><?= ($application->profile_id !== '1007')?' aux chercheurs(ses)':''; ?>' +
            '<?= ($application->profile_id !== '1008')?' et aux collectivités':''; ?>' +
            '.';

        let text = name+' '+desc+' '+addressed;
        if (text.length > 280) {
            text =  text.substring(0, 280 - 3) + '...';
        }

        Swal.fire({
            customClass: {
                title: "heading no-dash"
            },
            title: '<?= JText::_('SHARE_OFFER'); ?>',
            html: '<a href="https://twitter.com/intent/tweet?url='+encodeURIComponent('<?= JUri::base(); ?>')+'&text='+text+'" class="twitter-button cta-offre w-inline-block" target="_blank">Twitter</a>' +
                '<a href="https://www.facebook.com/sharer.php?u='+encodeURIComponent('<?= JUri::base(); ?>')+'" class="fb-button cta-offre w-inline-block" target="_blank">Facebook</a>' +
                '<a href="https://www.linkedin.com/sharing/share-offsite/?url='+encodeURIComponent('<?= JUri::base(); ?>')+'&summary='+text.replace(/ /g,"+")+'" class="linkedin-button cta-offre w-inline-block" target="_blank">LinkedIn</a>',
            showCloseButton: true,
            showConfirmButton: false
        });
    }

    /**
     *
     * @param link_id
     */
    function favorite(link_id) {

        const star_icon = document.querySelector('#card-'+link_id+' .em-star-button');
        const other_fav = star_icon.parentElement.parentElement.querySelector('.fa-star');

        jQuery.ajax({
            type: 'POST',
            url: 'index.php?option=com_emundus&controller=cifre&task=favorite',
            data: {
                link_id: link_id
            },
            beforeSend: function() {
                star_icon.classList.add('fa-spin');
            },
            success: function(result) {

                star_icon.classList.remove('fa-spin');

                result = JSON.parse(result);
                if (result.status) {
                    iconate(star_icon, {
                        from: 'fa-star-o',
                        to: 'fa-star',
                        animation: 'rotateClockwise'
                    });
                    star_icon.setAttribute('onclick', 'unfavorite('+link_id+')');
                    star_icon.setAttribute('id', 'favorite-'+link_id);
                    star_icon.setAttribute('data-original-title', '<?= JText::_('FAVORITE_CLICK_HERE_UNFAV');?>');

                    const other_fav_link_id = other_fav.id.split("-").pop();
                    iconate(other_fav, {
                        from: 'fa-star',
                        to: 'fa-star-o',
                        animation: 'rotateClockwise'
                    });
                    other_fav.setAttribute('onclick', 'favorite('+other_fav_link_id+')');
                    other_fav.removeAttribute('id');
                    other_fav.setAttribute('data-original-title', '<?= JText::_('FAVORITE_CLICK_HERE_FAV');?>');

                } else {
                    star_icon.style.color = '#d91e18';
                }
            },
            error: function(jqXHR) {
                star_icon.classList.remove('fa-spin');
                star_icon.style.color = '#d91e18';
                console.log(jqXHR.responseText);
            }
        });
    }


    /**
     *
     * @param link_id
     */
    function unfavorite(link_id) {

        const star_icon = document.querySelector('#card-'+link_id+' .em-star-button');

        jQuery.ajax({
            type: 'POST',
            url: 'index.php?option=com_emundus&controller=cifre&task=unfavorite',
            data: {
                link_id: link_id
            },
            beforeSend: function() {
                star_icon.classList.add('fa-spin');
            },
            success: function(result) {

                star_icon.classList.remove('fa-spin');

                result = JSON.parse(result);
                if (result.status) {
                    iconate(star_icon, {
                        from: 'fa-star',
                        to: 'fa-star-o',
                        animation: 'rotateClockwise'
                    });
                    star_icon.setAttribute('onclick', 'favorite('+link_id+')');
                    star_icon.removeAttribute('id');
                    star_icon.setAttribute('data-original-title', '<?= JText::_('FAVORITE_CLICK_HERE_FAV');?>');
                } else {
                    star_icon.style.color = '#d91e18';
                }
            },
            error: function(jqXHR) {
                star_icon.classList.remove('fa-spin');
                star_icon.style.color = '#d91e18';
                console.log(jqXHR.responseText);
            }
        });
    }

</script>
