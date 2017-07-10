<?php
/**
 * Securitycheck Pro package
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.installer.installer');

/**
 * Script file of Securitycheck Pro component
 */
class com_SecuritycheckproInstallerScript {
	// Check if we are calling update method. It's used in 'install_message' function
	public $update = false;
	
	// Resultado de la desinstalaci�n del componente Securitycheck
	public $result_free = "";
	public $id_free;
	
	// �'memory_limit' demasiado bajo?
	public $memory_limit = '';
	
	// url plugin habilitado?
	public $url_plugin_enabled = false;
		
	/** @var array Obsolete files and folders to remove  */
	private $ObsoleteFilesAndFolders = array(
		'files'	=> array(
			// Outdated media files
			'media/com_securitycheckpro/images/blocked.jpg',
			'media/com_securitycheckpro/images/dinamically_blocked.jpg',
			'media/com_securitycheckpro/images/http.jpg',
			'media/com_securitycheckpro/images/no_read.jpg',
			'media/com_securitycheckpro/images/oval_blue_left.gif',
			'media/com_securitycheckpro/images/oval_blue_right.gif',
			'media/com_securitycheckpro/images/oval_green_left.gif',
			'media/com_securitycheckpro/images/oval_green_right.gif',
			'media/com_securitycheckpro/images/permitted.jpg',
			'media/com_securitycheckpro/images/read.jpg',
			'media/com_securitycheckpro/images/second_level.jpg',
			'media/com_securitycheckpro/images/session_hijack.jpg',
			'media/com_securitycheckpro/images/session_protection.jpg',
			'media/com_securitycheckpro/images/task_running.gif',
			// Geoip outdated files
			'administrator/components/com_securitycheckpro/helpers/geoip.php',
			'administrator/components/com_securitycheckpro/helpers/GeoIP.dat',
			'administrator/components/com_securitycheckpro/helpers/geoblock.php',			
		)
	);
			
	/* Funci�n que desinstala el componente Securitycheck */
	private function _unistall_Securitycheck() {
		
		$db = JFactory::getDbo();
		$installer = new JInstaller();
		
		$columnName      = $db->quoteName("extension_id");
		$tableExtensions = $db->quoteName("#__extensions");
		$type 			 = $db->quoteName("type");
		$columnElement   = $db->quoteName("element");

		// Uninstall Securitycheck component
		$db->setQuery(
				"SELECT 
					$columnName
				FROM
					$tableExtensions
				WHERE
					$type='component'
				AND
					$columnElement='com_securitycheck'"		
		);

		$this->id_free = $db->loadResult();

		if ($this->id_free) {
			$this->result_free = $installer->uninstall('component',$this->id_free,1);
		}
	}
	
	/**
	 * Removes obsolete files and folders
	 *
	 * @param array $ObsoleteFilesAndFolders
	 */
	private function _removeObsoleteFilesAndFolders($ObsoleteFilesAndFolders)
	{
		$securitycheckpro_cached_file = JPATH_CACHE . '/com_securitycheckpro.updates.ini';
		
		// Remove cached files
		if ( JFile::exists($securitycheckpro_cached_file) ) {
			JFile::delete($securitycheckpro_cached_file);
		}
		
		// Remove files
		JLoader::import('joomla.filesystem.file');
		if(!empty($ObsoleteFilesAndFolders['files'])) foreach($ObsoleteFilesAndFolders['files'] as $file) {
			$f = JPATH_ROOT.'/'.$file;
			if(!JFile::exists($f)) continue;
			$res= JFile::delete($f);			
		}
		
		/* Remove folders (Not used now, but could be useful in a future)
		JLoader::import('joomla.filesystem.file');
		if(!empty($ObsoleteFiles['folders'])) foreach($ObsoleteFiles['folders'] as $folder) {
			$f = JPATH_ROOT.'/'.$folder;
			if(!JFolder::exists($f)) continue;
			JFolder::delete($f);
		}*/
	}
	
	/* Chequea las opciones para lanzar el Cron y las adapta al formato de la versi�n 2.8.0 */
	private function _280_version_changes() {
	
		// Extraemos la informaci�n necesario de la tabla #_extensions 		
		$db = JFactory::getDBO();
		$query = 'SELECT * FROM #__extensions WHERE (name="securitycheckpro")' ;
		$db->setQuery( $query );
		$db->execute();
		$result = $db->loadAssocList();
		
		// Si no existe versi�n previa no es necesario hacer ninguna acci�n
		if ( !empty($result) ) {
		
			// Decodificamos la informaci�n de la versi�n, que est� en formato json en la entrada 'manifest_cache'
			$stack = json_decode($result[0]["manifest_cache"], true);
			
			// Versi�n de Securitycheck Pro instalada
			$scpro_version = $stack["version"];
			
			// Si la versi�n instalada es menor a la 2.8.0, hemos de realizar las comprobaciones
			if ( version_compare($scpro_version,"2.8.0","lt") ) {
				// Extraemos las opciones de configuraci�n del Cron
				$query = 'SELECT storage_value FROM #__securitycheckpro_storage WHERE (storage_key="cron_plugin")' ;
				$db->setQuery( $query );
				$db->execute();
				$result = $db->loadAssocList();
								
				if ( !empty($result) ) {
					$stack = json_decode($result[0]["storage_value"], true);
					
					/* Si la periodicidad estaba establecida a 1 (Diaria), la hemos de establecer a 24 (Diaria a partir de la versi�n 2.8.0)
					Si estaba establecida a 7 (Semanal), la hemos de cambiar a 168 (Semanal a partir de la versi�n 2.8.0) */
					
					if ( $stack["periodicity"] == 1 ) {
						$stack["periodicity"] = 24;
					} else if ( $stack["periodicity"] == 7 ) {
						$stack["periodicity"] = 168;
					}
						
					// Sobreescribimos las opciones del Cron en la bbdd
					$object = (object)array(
						'storage_key'	=> 'cron_plugin',
						'storage_value'	=> (json_encode($stack))							
					);
						
					// Borramos los valores existentes
					$query = $db->getQuery(true)
						->delete($db->quoteName('#__securitycheckpro_storage'))
						->where($db->quoteName('storage_key').' = '.$db->quote('cron_plugin'));
					$db->setQuery($query);
					$db->execute();
		
					try {
						$db->insertObject('#__securitycheckpro_storage', $object);
					} catch (Exception $e) {	
						JFactory::getApplication()->enqueueMessage(JText::_('Error updating Cron settings. Please, check your Periodicity.'), 'Warning');
					}
				}
			}
		}
		
	}
	
	/**
	 * Joomla! pre-flight event
	 * 
	 * @param string $type Installation type (install, update, discover_install)
	 * @param JInstaller $parent Parent object
	 */
	public function preflight($type, $parent)
	{
		// Only allow to install on PHP 5.3.0 or later
		if ( !version_compare(PHP_VERSION, '5.3.0', 'ge') ) {
			Jerror::raiseWarning(null, "Securitycheck Pro requires, at least, PHP 5.3.0");
			return false;
		} else if ( version_compare(JVERSION, '3.0.0', 'lt') ) {
			// Only allow to install on Joomla! 3.0.0 or later, but not in 2.5 branch
			Jerror::raiseWarning(null, "This version doesn't work in Joomla! 2.5 branch");
			return false;
		}
		
		// Check if the 'mb_strlen' function is enabled
		if ( !function_exists("mb_strlen") ) {
			Jerror::raiseWarning(null, "The 'mb_strlen' function is not installed in your host. Please, ask your hosting provider about how to install it.");
			return false;
		}
		
		// Do changes for 2.8.0 version in Cron
		$this->_280_version_changes();
		
		$this->_removeObsoleteFilesAndFolders($this->ObsoleteFilesAndFolders);
		
		$this->_unistall_Securitycheck();
	}
	
	/**
	 * Runs after install, update or discover_update
	 * @param string $type install, update or discover_update
	 * @param JInstaller $parent 
	 */
	function postflight( $type, $parent )
	{
		// Inicializamos las variables
		$existe_tabla = false;
				
		$db = JFactory::getDBO();
		$total_rows = $db->getTableList();
		
		if ( !(is_null($total_rows)) ) {
			foreach ($total_rows as $table_name) {
				if ( strstr($table_name,"securitycheckpro_logs") ) {
					$existe_tabla = true;
				}
			}
		}
		
		if ( !$existe_tabla ) {
			// Disable Securitycheck Pro plugin
			$tableExtensions = $db->quoteName("#__extensions");
			$columnElement   = $db->quoteName("element");
			$columnType      = $db->quoteName("type");
			$columnEnabled   = $db->quoteName("enabled");
			$db->setQuery(
				"UPDATE 
					$tableExtensions
				SET
					$columnEnabled=0
				WHERE
					$columnElement='securitycheckpro'
				AND
					$columnType='plugin'"
			);
			$db->execute();
			
			// Disable Securitycheck Pro Cron plugin
			$db->setQuery(
				"UPDATE 
					$tableExtensions
				SET
					$columnEnabled=0
				WHERE
					$columnElement='securitycheckpro_cron'
				AND
					$columnType='plugin'"
			);

		$db->execute();
			Jerror::raiseWarning(null, "There has been an error when creating database tables. Securitycheck Pro Web Firewall and Cron plugin has been disabled.");
		}		
		
	}
	
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) {
		// General settings
		$status = new JObject();
		$status->modules = array();
		
		// Array to store module and plugin installation results
		$result = array();
		$indice = 0;
		
		$installer = new JInstaller();
		
		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");

		// Install module
		$db = JFactory::getDbo();
		$result[$indice] = $installer->install($source. DIRECTORY_SEPARATOR .'modules' . DIRECTORY_SEPARATOR .'mod_scpadmin_quickicons');
		$indice++;
				
		// Enable and configure module
		$query = "UPDATE #__modules SET position='icon', ordering = '-10', published = '1' WHERE `module`='mod_scpadmin_quickicons'";
		$db->setQuery($query);
		$db->execute();

		$query = "SELECT `id` FROM `#__modules` WHERE `module` = 'mod_scpadmin_quickicons'";
		$db->setQuery($query);
		(int) $modID = $db->loadResult();
		
		// If the module_id is empty, we'll get an SQL error and the installion process will break
		if ( (!empty($modID)) && (is_int($modID)) ) {
			$query = "REPLACE INTO `#__modules_menu` (`moduleid`,`menuid`) VALUES ({$modID}, 0)";
			$db->setQuery($query);
			$db->execute();
		}
				
		$status->modules[] = array('name'=>'Securitycheck Pro - Quick Icons','client'=>'administrator', 'result'=>$result); 
		
		// Install plugins
						
		foreach($manifest->plugins->plugin as $plugin) {
			$installer = new JInstaller();
			$attributes = $plugin->attributes();
			$plg = $source . DIRECTORY_SEPARATOR . $attributes['folder']. DIRECTORY_SEPARATOR . $attributes['plugin'];
			$result[$indice] = $installer->install($plg);
			$indice++;
		}
		
		// Update the URL inspector plugin ordering; it must be published the last
		$query = "UPDATE #__extensions SET ordering = '-100' WHERE `name`='System - url inspector'";
		$db->setQuery($query);
		$db->execute();
		
		// Check if url plugin is enabled
		$query = "SELECT enabled from #__extensions WHERE `name`='System - url inspector'";
		$db->setQuery($query);
		$this->url_plugin_enabled = $db->loadResult();

		$db = JFactory::getDbo();
		$tableExtensions = $db->quoteName("#__extensions");
		$columnElement   = $db->quoteName("element");
		$columnType      = $db->quoteName("type");
		$columnEnabled   = $db->quoteName("enabled");
            
		// Enable Securitycheck Pro plugin
		$db->setQuery(
			"UPDATE 
				$tableExtensions
			SET
				$columnEnabled=1
			WHERE
				$columnElement='securitycheckpro'
			AND
				$columnType='plugin'"
		);

		$db->execute();
		
		
		// Enable Securitycheck Pro Installer plugin
		$db->setQuery(
			"UPDATE 
				$tableExtensions
			SET
				$columnEnabled=1
			WHERE
				$columnElement='securitycheckpro_installer'
			AND
				$columnType='plugin'"
		);

		$db->execute();
				
		// Extract 'memory_limit' value cutting the last character
		$memory_limit = ini_get('memory_limit');
		$memory_limit = (int) substr($memory_limit,0,-1);
				
		// If $memory_limit value is less or equal than 128, then whe will not enable de Cron plugin to avoid issues
		if ( ($memory_limit > 128) && (!$this->update) ) {
		
			// Enable Securitycheck Pro Cron plugin
			$db->setQuery(
				"UPDATE 
					$tableExtensions
				SET
					$columnEnabled=1
				WHERE
					$columnElement='securitycheckpro_cron'
				AND
					$columnType='plugin'"
			);

			$db->execute();
		}
		
		// Install message
		$this->install_message($this->id_free,$this->result_free,$result,$status,$memory_limit); 
	}
	
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent){
	
		// General settings
		$status = new JObject();
		$status->modules = array();
		
		// Array to store uninstall results
		$result = array();
		
		$db = JFactory::getDbo();
		
		// Uninstall module
		$db->setQuery("SELECT extension_id FROM #__extensions WHERE type = 'module' AND element = 'mod_scpadmin_quickicons' LIMIT 1");
		(int) $id = $db->loadResult();
		if ($id) {
			$installer = new JInstaller();
			$result[0] = $installer->uninstall('module', $id);
			$status->modules[] = array('name'=>'Securitycheck Pro - Quick Icons','client'=>'administrator', 'result'=>$result);			
		}
		
		$columnName      = $db->quoteName("extension_id");
		$tableExtensions = $db->quoteName("#__extensions");
		$type 			 = $db->quoteName("type");
		$columnElement   = $db->quoteName("element");
		$columnType      = $db->quoteName("folder");
		$result = '';
            
		// Uninstall  Securitycheck Pro plugin
		$db->setQuery(
			"SELECT 
				$columnName
			FROM
				$tableExtensions
			WHERE
				$type='plugin'
			AND
				$columnElement='securitycheckpro'
			AND
				$columnType='system'"
		
		);

		$id = $db->loadResult();

		if ($id) {
			$installer = new JInstaller();
			$result[1] = $installer->uninstall('plugin',$id,1);		
		}
		
		// Uninstall  Securitycheck Pro Cron plugin
		$db->setQuery(
			"SELECT 
				$columnName
			FROM
				$tableExtensions
			WHERE
				$type='plugin'
			AND
				$columnElement='securitycheckpro_cron'
			AND
				$columnType='system'"
		
		);

		$id = $db->loadResult();

		if ($id) {
			$installer = new JInstaller();
			$result[2] = $installer->uninstall('plugin',$id,1);		
		}
		
		// Uninstall  Securitycheck Pro URL inspector
		$db->setQuery(
			"SELECT 
				$columnName
			FROM
				$tableExtensions
			WHERE
				$type='plugin'
			AND
				$columnElement='url_inspector'
			AND
				$columnType='system'"
		
		);

		$id = $db->loadResult();

		if ($id) {
			$installer = new JInstaller();
			$result[3] = $installer->uninstall('plugin',$id,1);		
		}
		
		// Uninstall Installer plugin
		$db->setQuery(
			"SELECT 
				$columnName
			FROM
				$tableExtensions
			WHERE
				$type='plugin'
			AND
				$columnElement='securitycheckpro_installer'
			AND
				$columnType='installer'"
		
		);

		$id = $db->loadResult();

		if ($id) {
			$installer = new JInstaller();
			$result[4] = $installer->uninstall('plugin',$id,1);		
		}
		
		// Uninstall message
		$this->uninstall_message($result,$status);
		
	}
	
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) {
		// This variable is updated.
		$this->update = true;		
		$this->install($parent);
	}
	
	/**
	 * method to show the install message
	 *
	 * @return void
	 */
	function install_message($id_free,$result_free,$result,$status,$memory_limit){
		// Initialize variables
		$cabecera = '';
		$result_ok = '';
		$result_not_ok = '';
			
		if ( !($this->update) ) {
			$cabecera = JText::_( 'COM_SECURITYCHECKPRO_HEADER_INSTALL' );
			$result_ok = JText::_( 'COM_SECURITYCHECKPRO_INSTALLED' );
			$result_not_ok = JText::_( 'COM_SECURITYCHECKPRO_NOT_INSTALLED' );
		} else {
			$cabecera = JText::_( 'COM_SECURITYCHECKPRO_HEADER_UPDATE' );
			$result_ok = JText::_( 'COM_SECURITYCHECKPRO_UPDATED' );
			$result_not_ok = JText::_( 'COM_SECURITYCHECKPRO_NOT_UPDATED' );
		}
		
?>
		<img src='../media/com_securitycheckpro/images/tick_48x48.png' style='float: left; margin: 5px;'>
		<?php
			if ( !($this->update) ) {			
		?>
			<h1><?php echo $cabecera ?></h1>
			<h2><?php echo JText::_( 'COM_SECURITYCHECKPRO_WELCOME' ); ?></h2>
		<?php 
			} else {
		?>
			<h2><?php echo $cabecera ?></h2>
		<?php
			}
		?>
			<div class="securitycheck-bootstrap">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="title" colspan="2"><?php echo JText::_( 'COM_SECURITYCHECKPRO_EXTENSION' ); ?></th>
						<th width="30%"><?php echo JText::_( 'COM_SECURITYCHECKPRO_STATUS' ); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="3"></td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td colspan="2">Securitycheck Pro <?php echo JText::_( 'COM_SECURITYCHECKPRO_COMPONENT' ); ?></td>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . $result_ok; ?>
							</span>
						</td>
					</tr>
					<tr class="row0">
						<td class="key" colspan="2">Securitycheck Pro <?php echo JText::_( 'COM_SECURITYCHECKPRO_PLUGIN' ); ?></td>
					<?php
						if ( $result[1] ) {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-success\">";								
								?>
								<?php echo $span . $result_ok; ?>
								</span>
								<?php 
									$span = "<span class=\"label label-info\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_ENABLED' );																					
								?>
								<?php echo $span . $message; ?>
							</td>
					<?php
						} else {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-important\">";								
								?>
								<?php echo $span . $result_not_ok; ?>
								</span>
							</td>
					<?php
						}
					?>
					</tr>
					<tr class="row0">
						<td class="key" colspan="2">Securitycheck Pro Cron <?php echo JText::_( 'Plugin' ); ?></td>
					<?php
						if ( $result[2] ) {
					?>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . $result_ok; ?>
							</span>
							<?php 
								$limit = false;
								if ( $this->update ) {
									$span = "<span class=\"label label-info\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_ENABLED' );
								} else if ( $memory_limit > 128 ) {
									$span = "<span class=\"label label-info\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_ENABLED' );
								} else if ( $memory_limit <= 128 ) {
									$span = "<span class=\"label label-warning\">";
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_DISABLED' );
									$limit = true;
								}
							?>
							<?php echo $span . $message; ?>
							</span>
							<?php
								if ( $limit ) {
							?>
								<br/>
								<tr>
									<td>
										<?php echo JText::_( 'COM_SECURITYCHECKPRO_MEMORY_LIMIT_LOW' ); ?>	
									</td>								 
								</tr>
							<?php
							}
							?>
						</td>
					<?php
						} else {
					?>
						<td>
							<?php 
								$span = "<span class=\"label label-important\">";								
							?>
							<?php echo $span . $result_not_ok; ?>
							</span>
						</td>
					<?php
						}
					?>
					</tr>
					<tr class="row0">
						<td class="key" colspan="2">URL Inspector <?php echo JText::_( 'Plugin' ); ?></td>
					<?php
						if ( $result[3] ) {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-success\">";								
								?>
								<?php echo $span . $result_ok; ?>
								</span>
								<?php 
								if ( $this->url_plugin_enabled ) {
									$span = "<span class=\"label label-info\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_ENABLED' );
								} else {
									$span = "<span class=\"label label-important\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_DISABLED' );
								}
							?>
							<?php echo $span . $message; ?>								
							</td>
					<?php
						} else {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-important\">";								
								?>
								<?php echo $span . $result_not_ok; ?>
								</span>
							</td>
					<?php
						}
					?>
					</tr>
					<tr class="row0">
						<td class="key" colspan="2">Installer <?php echo JText::_( 'Plugin' ); ?></td>
					<?php
						if ( $result[4] ) {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-success\">";								
								?>
								<?php echo $span . $result_ok; ?>
								</span>
								<?php 
									$span = "<span class=\"label label-info\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_ENABLED' );																					
								?>
								<?php echo $span . $message; ?>
							</td>
					<?php
						} else {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-important\">";								
								?>
								<?php echo $span . $result_not_ok; ?>
								</span>
							</td>
					<?php
						}
					?>
					</tr>
					<?php
					if ( count($status->modules) > 0 ) {
					?>
						<tr class="row0">
						<td class="key" colspan="2">Securitycheck Pro Info <?php echo JText::_( 'COM_SECURITYCHECKPRO_MODULE' ); ?></td>
					<?php
							if ($status->modules['0']['result']) {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-success\">";								
								?>
								<?php echo $span . $result_ok; ?>
								</span>
								<?php 
									$span = "<span class=\"label label-info\">";	
									$message = JText::_( 'COM_SECURITYCHECKPRO_PLUGIN_ENABLED' );																					
								?>
								<?php echo $span . $message; ?>
							</td>
					<?php
							} else {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-important\">";								
								?>
								<?php echo $span . $result_not_ok; ?>
								</span>
							</td>							
					<?php
							}
					?>
						</tr>
					<?php
					}
					if ($id_free) {
					?>
						<tr class="row0">
							<td class="key" colspan="2">Securitycheck <?php echo JText::_( 'COM_SECURITYCHECK_COMPONENT' ); ?></td>
					<?php
							if ($result_free) {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-success\">";								
								?>
								<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED'); ?>
								</span>
							</td>									
					<?php
							} else {
					?>
							<td>
								<?php 
									$span = "<span class=\"label label-important\">";								
								?>
								<?php echo $span . JText::_( 'COM_SECURITYCHECK_NOT_UNINSTALLED'); ?>
								</span>
							</td>							
					<?php
							}
					?>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			</div>
<?php
	}

	/**
	 * method to show the uninstall message
	 *
	 * @return void
	 */
	function uninstall_message($result,$status){
?>
		<h1><?php echo JText::_( 'COM_SECURITYCHECKPRO_HEADER_UNINSTALL' ); ?></h1>
		<h2><?php echo JText::_( 'COM_SECURITYCHECKPRO_GOODBYE' ); ?></h2>
		<div class="securitycheck-bootstrap">
		<table class="table table-striped">
			<thead>
				<tr>
					<th class="title" colspan="2"><?php echo JText::_( 'COM_SECURITYCHECKPRO_EXTENSION' ); ?></th>
					<th width="30%"><?php echo JText::_( 'COM_SECURITYCHECKPRO_STATUS' ); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3"></td>
				</tr>
			</tfoot>
			<tbody>
				<tr>
					<td colspan="2">Securitycheck Pro <?php echo JText::_( 'COM_SECURITYCHECKPRO_COMPONENT' ); ?></td>
					<td>
						<?php 
							$span = "<span class=\"label label-success\">";								
						?>
						<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED' ); ?>
						</span>
					</td>					
				</tr>
				<tr class="row0">
					<td class="key" colspan="2">Securitycheck Pro <?php echo JText::_( 'COM_SECURITYCHECKPRO_PLUGIN' ); ?></td>
				<?php
					if ($result[1]) {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED' ); ?>
							</span>
						</td>
				<?php
					} else {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-important\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_NOT_INSTALLED' ); ?>
							</span>
						</td>						
				<?php
					}
				?>
				</tr>
				<tr class="row0">
					<td class="key" colspan="2">Securitycheck Pro Cron <?php echo JText::_( 'Plugin' ); ?></td>
				<?php
					if ($result[2]) {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED' ); ?>
							</span>
						</td>
				<?php
					} else {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-important\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_NOT_INSTALLED' ); ?>
							</span>
						</td>
				<?php
					}
				?>
				</tr>
				<tr class="row0">
					<td class="key" colspan="2">URL Inspector <?php echo JText::_( 'Plugin' ); ?></td>
				<?php
					if ($result[3]) {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED' ); ?>
							</span>
						</td>
				<?php
					} else {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-important\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_NOT_INSTALLED' ); ?>
							</span>
						</td>
				<?php
					}
				?>
				</tr>
				<tr class="row0">
					<td class="key" colspan="2">Installer <?php echo JText::_( 'Plugin' ); ?></td>
				<?php
					if ($result[4]) {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED' ); ?>
							</span>
						</td>
				<?php
					} else {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-important\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_NOT_INSTALLED' ); ?>
							</span>
						</td>
				<?php
					}
				?>
				</tr>
				<?php
				if ( count($status->modules) > 0 ) {
				?>
					<tr class="row0">
					<td class="key" colspan="2">Securitycheck Pro Info <?php echo JText::_( 'COM_SECURITYCHECKPRO_MODULE' ); ?></td>
				<?php
					if ($status->modules['0']['result']) {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-success\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_UNINSTALLED' ); ?>
							</span>
						</td>
				<?php
					} else {
				?>
						<td>
							<?php 
								$span = "<span class=\"label label-important\">";								
							?>
							<?php echo $span . JText::_( 'COM_SECURITYCHECKPRO_NOT_INSTALLED' ); ?>
							</span>
						</td>
				<?php
					}
				?>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		</div>
<?php
	}
}
?>