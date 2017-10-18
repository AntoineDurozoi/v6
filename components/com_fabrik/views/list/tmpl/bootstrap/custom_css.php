<?php
/**
 * Fabrik List Template: Default Custom CSS
 *
 * @package     Joomla
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005-2016  Media A-Team, Inc. - All rights reserved.
 * @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

/**
* If you need to make small adjustments or additions to the CSS for a Fabrik
* list template, you can create a custom_css.php file, which will be loaded after
* the main template_css.php for the template.
*
* This file will be invoked as a PHP file, so the list ID
* can be used in order to narrow the scope of any style changes.  You do
* this by prepending #listform_$c to any selectors you use.  This will become
* (say) #listform_12, owhich will be the HTML ID of your list on the page.
*
* See examples below, which you should remove if you copy this file.
*
* Don't edit anything outside of the BEGIN and END comments.
*
* For more on custom CSS, see the Wiki at:
*
* http://www.fabrikar.com/forums/index.php?wiki/form-and-details-templates/#the-custom-css-file
*
* NOTE - for backward compatibility with Fabrik 2.1, and in case you
* just prefer a simpler CSS file, without the added PHP parsing that
* allows you to be be more specific in your selectors, we will also include
* a custom.css we find in the same location as this file.
*
*/

header('Content-type: text/css');
$c = $_REQUEST['c'];
echo <<<EOT
/* BEGIN - Your CSS styling starts here */

#listform_$c .fabrikForm {
	margin-top: 25px !important;
}

#listform_$c .label-lightblue {
    background-color: #6bb9F0 !important;
}
#listform_$c .label-blue {
    background-color: #19B5FE !important;
}
#listform_$c .label-darkblue {
    background-color: #013243 !important;
}
#listform_$c .label-lightgreen {
    background-color: #00E640 !important;
}
#listform_$c .label-green {
    background-color: #3FC380 !important;
}
#listform_$c .label-darkgreen {
    background-color: #1E824C !important;
}
#listform_$c .label-lightyellow {
    background-color: #FFFD7E !important;
}
#listform_$c .label-yellow {
    background-color: #FFFD54 !important;
}
#listform_$c .label-darkyellow {
    background-color: #F7CA18 !important;
}
#listform_$c .label-lightorange {
    background-color: #FABE58 !important;
}
#listform_$c .label-orange {
    background-color: #E87E04 !important;
}
#listform_$c .label-darkorange {
    background-color: #D35400 !important;
}
#listform_$c .label-lightred {
    background-color: #EC644B !important;
}
#listform_$c .label-red {
    background-color: #CF000F !important;
}
#listform_$c .label-darkred {
    background-color: #96281B !important;
}
#listform_$c .label-lightpurple {
    background-color: #DCC6E0 !important;
}
#listform_$c .label-purple {
    background-color: #947CB0 !important;
}
#listform_$c .label-darkpurple {
    background-color: #663399 !important;
}

/* END - Your CSS styling ends here */
EOT;
