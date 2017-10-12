<?php

defined('_JEXEC') or die('Access Deny');
require_once(dirname(__FILE__).DS.'helper.php');

$session = JFactory::getSession();
$user = $session->get('emundusUser');
$helper = new modEmundusBookInterviewHelper;

if (isset($user->fnum)) {

    // First we need to check if the user has booked.
    // If the user has not, we will display a button that opens a modal allowing them to book an event (and so we need to get the event info).
    // If the user has we will display the date of their interview.
    $user_booked = $helper->hasUserbooked($user->id);

    if ($user_booked) {

        $offset = JFactory::getConfig()->get('offset');
        
        $next_interview = $helper->getNextInterview($user);
        $interview_dt   = new DateTime($next_interview->start_date, new DateTimeZone('GMT'));
        $interview_dt->setTimezone(new DateTimeZone($offset));
        $interview_date = $interview_dt->format('M j Y');
        $interview_time = $interview_dt->format('g:i A');
        require(JModuleHelper::getLayoutPath('mod_emundus_book_interview','showInterview'));    

    } else {

        $available_events = $helper->getEvents($user);
        require(JModuleHelper::getLayoutPath('mod_emundus_book_interview','default'));    

    }

}
    
?>