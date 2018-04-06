<?php
/**
* Modelo Securitycheckpros para el Componente Securitycheckpro
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Chequeamos si el archivo est� inclu�do en Joomla!
defined('_JEXEC') or die();


/**
* Modelo Securitycheck
*/
class SecuritycheckprosModelUpload extends JModelLegacy
{

/* Funci�n que sube un fichero de configuraci�n de la extensi�n Securitycheck Pro (previamente exportado) y establece esa configuraci�n sobreescribiendo la actual */
function read_file()
{
	$res = true;
	$secret_key = "";
	
	// Get the uploaded file information
	$userfile = JRequest::getVar('file_to_import', null, 'files', 'array');
		
	// Make sure that file uploads are enabled in php
	if (!(bool) ini_get('file_uploads'))
	{
		JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLFILE'));
		return false;
	}

	// If there is no uploaded file, we have a problem...
	if (!is_array($userfile))
	{
		JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_NO_FILE_SELECTED'));
		return false;
	}
	
	//First check if the file has the right extension, we need txt only
	if ( !(strtolower(JFile::getExt($userfile['name']) ) == 'txt') ) {
		JError::raiseWarning('', JText::_('COM_SECURITYCHECKPRO_INVALID_FILE_EXTENSION'));
		return false;
	}

	// Check if there was a problem uploading the file.
	if ($userfile['error'] || $userfile['size'] < 1)
	{
		JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR'));
		return false;
	}

	// Build the appropriate paths
	$config		= JFactory::getConfig();
	$tmp_dest	= $config->get('tmp_path') . '/' . $userfile['name'];
	$tmp_src	= $userfile['tmp_name'];

	// Move uploaded file
	jimport('joomla.filesystem.file');
	$upload_res = JFile::upload($tmp_src, $tmp_dest);
	
	// El fichero se ha subido correctamente
	if ($upload_res) {
		// Leemos el contenido del fichero, que ha de estar en formato json
		$file_content = file_get_contents($tmp_dest);
		$file_content_json = json_decode($file_content,true);
		
		$db = JFactory::getDBO();
		
		// Si hay contenido...
		if ( !empty($file_content_json) ) {
			// ... y lo recorremos y extraemos los pares 'storage_key' y 'storage_value'
			foreach ($file_content_json as $entry) {
			
				// Configuraci�n del firewall web
				if ( array_key_exists("storage_key",$entry) ) {
										
					// Instanciamos un objeto para almacenar los datos que ser�n sobreescritos
					$object = new StdClass();					
					$object->storage_key = $entry["storage_key"];
					$object->storage_value = $entry['storage_value'];
					
					// Comprobamos si hay alg�n dato a�adido o la tabla es null; dependiendo del resultado haremos un 'update' o un 'insert'
					$query = $db->getQuery(true)
						->select(array('storage_key'))
						->from($db->quoteName('#__securitycheckpro_storage'))
						->where($db->quoteName('storage_key').' = '.$db->quote($entry["storage_key"]));
					$db->setQuery($query);
					$exists = $db->loadResult();
																	
					try {
						// A�adimos los datos a la BBDD	
						if ( is_null($exists) ) {
							$res = $db->insertObject('#__securitycheckpro_storage', $object);
						} else {
							$res = $db->updateObject('#__securitycheckpro_storage', $object, 'storage_key');
						}
							
						if ( !$res ) {
							JError::raiseWarning('', JText::_('COM_SECURITYCHECKPRO_ERROR_IMPORTING_DATA'));
							return false;
						}
					} catch (Exception $e) {	
						JError::raiseWarning('', JText::_('COM_SECURITYCHECKPRO_ERROR_IMPORTING_DATA'));
						return false;
					}
				// Configuraci�n del componente
				} else if ( array_key_exists("params",$entry) ) {
					
					// Obtenemos el extension_id de la extensi�n, necesario para actualizar la informaci�n
					$query = 'SELECT extension_id FROM #__extensions WHERE name="Securitycheck Pro" and type="component"';
					$db->setQuery( $query );
					$db->execute();
					$id = $db->loadResult();
					
					// Instanciamos un objeto para almacenar los datos que ser�n sobreescritos
					$object = new StdClass();					
					$object->extension_id = $id;
					$object->params = $entry['params'];
																			
					try {
						// A�adimos los datos a la BBDD
						$res = $db->updateObject('#__extensions', $object, 'extension_id');		
						
						if ( !$res ) {
							JError::raiseWarning('', JText::_('COM_SECURITYCHECKPRO_ERROR_IMPORTING_DATA'));
							return false;
						}
					} catch (Exception $e) {	
						JError::raiseWarning('', JText::_('COM_SECURITYCHECKPRO_ERROR_IMPORTING_DATA'));
						return false;
					}
				}
			}
			// Borramos el archivo subido...
			JFile::delete($tmp_dest);
			// ... y mostramos un mensaje de �xito
			JFactory::getApplication()->enqueueMessage(JText::_('COM_SECURITYCHECKPRO_IMPORT_SUCCESSFULLY'));
		
		} else {
			JError::raiseWarning('', JText::_('COM_INSTALLER_MSG_INSTALL_WARNINSTALLUPLOADERROR'));
			return false;			
		}		
	}
	
	return $res;
}

}