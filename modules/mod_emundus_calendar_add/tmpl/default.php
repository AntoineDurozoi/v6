<?php
defined('_JEXEC') or die; 

$lang = JFactory::getLanguage();
$locallang = $lang->getTag(); 
if ($locallang == "fr-FR")
    setlocale(LC_TIME, 'fr', 'fr_FR', 'french', 'fra', 'fra_FRA', 'fr_FR.ISO_8859-1', 'fra_FRA.ISO_8859-1', 'fr_FR.utf8', 'fr_FR.utf-8', 'fra_FRA.utf8', 'fra_FRA.utf-8');
else
    setlocale (LC_ALL, 'en_GB');

?>

    <div class="col-md-2">
        <button type="button" data-toggle="modal" data-target="#em-modal-form" class="btn btn-success" id="addCalendar"><?php echo JText::_("MOD_EM_CALENDAR_ADD"); ?></button>
    </div>

    <div class="modal fade" id="em-modal-form" style="z-index:99999" tabindex="-1" role="dialog" aria-labelledby="em-modal-actions"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="em-modal-actions-title">
                        <?php echo JText::_("MOD_EM_CALENDAR_ADD"); ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="mod_emundus_calendar_add.php" method="post">
                        <div class="form-group">
                            <label for="em-calendar-title"><?php echo JText::_("MOD_EM_CALENDAR_TITLE"); ?></label>
                            <input type="text" class="form-control" id="em-calendar-title" aria-describedby="titleHelp">
                            <small id="titleHelp" class="form-text text-muted"><?php echo JText::_("MOD_EM_CALENDAR_TITLE_HELP"); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="em-calendar-program"><?php echo JText::_("MOD_EM_CALENDAR_PROGRAM"); ?></label>
                            <select class="form-control" id="em-calendar-program" aria-describedby="programHelp">
                                <option value=""><?php echo JText::_("MOD_EM_CALENDAR_PICK_A_PROGRAM"); ?></option>
                                <?php foreach($programs as $program) :?>
                                    <option value="<?php echo $program->code; ?>"><?php echo $program->label; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="programHelp" class="form-text text-muted"><?php echo JText::_("MOD_EM_CALENDAR_PROGRAM_HELP"); ?></small>
                        </div>

                        <div class="form-group">
                            <label for="em-calendar-color"><?php echo JText::_("MOD_EM_CALENDAR_COLOR"); ?></label>
                            <select class="form-control" id="em-calendar-color" aria-describedby="colorHelp">
                                <option value="" selected="selected"><?php echo JText::_("MOD_EM_CALENDAR_PICK_A_COLOR"); ?></option>
                                <option value="000000"><?php echo JText::_("MOD_EM_CALENDAR_BLACK"); ?></option>
                                <option value="FFFFFF"><?php echo JText::_("MOD_EM_CALENDAR_WHITE"); ?></option>
                                <option value="808080"><?php echo JText::_("MOD_EM_CALENDAR_GREY"); ?></option>
                                <option value="0010FF"><?php echo JText::_("MOD_EM_CALENDAR_BLUE"); ?></option>
                                <option value="FF0000"><?php echo JText::_("MOD_EM_CALENDAR_RED"); ?></option>
                                <option value="49E70D"><?php echo JText::_("MOD_EM_CALENDAR_GREEN"); ?></option>
                                <option value="F9A007"><?php echo JText::_("MOD_EM_CALENDAR_ORANGE"); ?></option>
                                <option value="A90EF0"><?php echo JText::_("MOD_EM_CALENDAR_PURPLE"); ?></option>
                                <option value="F5F50B"><?php echo JText::_("MOD_EM_CALENDAR_YELLOW"); ?></option>
                                <option value="F790EC"><?php echo JText::_("MOD_EM_CALENDAR_PINK"); ?></option>
                                <option value="00FFFF"><?php echo JText::_("MOD_EM_CALENDAR_CYAN"); ?></option>
                                <option value="7CFC00"><?php echo JText::_("MOD_EM_CALENDAR_GREEN_APPLE"); ?></option>
                                <option value="0C6F02"><?php echo JText::_("MOD_EM_CALENDAR_DARK_GREEN"); ?></option>
                                <option value="021265"><?php echo JText::_("MOD_EM_CALENDAR_DARK_BLUE"); ?></option>
                                <option value="91A2FC"><?php echo JText::_("MOD_EM_CALENDAR_SKY_BLUE"); ?></option>
                                <option value="890303"><?php echo JText::_("MOD_EM_CALENDAR_MAROON"); ?></option>
                                <option value="D56904"><?php echo JText::_("MOD_EM_CALENDAR_BROWN"); ?></option>
                                <option value="733801"><?php echo JText::_("MOD_EM_CALENDAR_DARK_BROWN"); ?></option>
                                <option value="E18C2C"><?php echo JText::_("MOD_EM_CALENDAR_LIGHT_BROWN"); ?></option>
                                <option value="E5AC15"><?php echo JText::_("MOD_EM_CALENDAR_GOLD"); ?></option>
                                <option value="C0C0C0"><?php echo JText::_("MOD_EM_CALENDAR_SILVER"); ?></option>
                                <option value="F5F5DC"><?php echo JText::_("MOD_EM_CALENDAR_BEIGE"); ?></option>
                                <option value="F7DD5D"><?php echo JText::_("MOD_EM_CALENDAR_SAND"); ?></option>
                            </select>
                            <small id="colorHelp" class="form-text text-muted"><?php echo JText::_("MOD_EM_CALENDAR_COLOR_HELP"); ?></small>
                        </div>

                        <button type="button" class="btn btn-primary" name="btnAddcal"><?php echo JText::_("MOD_EM_CALENDAR_SUBMIT"); ?></button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    
    <script src=""></script>