<?php
/**
 * WorkspaceFolderContents
 *
 * PHP version 5
 *
 * @category Class
 * @package  DocuSign\eSign
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * DocuSign REST API
 *
 * The DocuSign REST API provides you with a powerful, convenient, and simple Web services API for interacting with DocuSign.
 *
 * OpenAPI spec version: v2
 * Contact: devcenter@docusign.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace DocuSign\eSign\Model;

use \ArrayAccess;

/**
 * WorkspaceFolderContents Class Doc Comment
 *
 * @category    Class
 * @description Provides properties that describe the contents of a workspace folder.
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class WorkspaceFolderContents implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'workspaceFolderContents';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'end_position' => 'string',
        'folder' => '\DocuSign\eSign\Model\WorkspaceItem',
        'items' => '\DocuSign\eSign\Model\WorkspaceItem[]',
        'parent_folders' => '\DocuSign\eSign\Model\WorkspaceItem[]',
        'result_set_size' => 'string',
        'start_position' => 'string',
        'total_set_size' => 'string',
        'workspace_id' => 'string'
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'end_position' => 'endPosition',
        'folder' => 'folder',
        'items' => 'items',
        'parent_folders' => 'parentFolders',
        'result_set_size' => 'resultSetSize',
        'start_position' => 'startPosition',
        'total_set_size' => 'totalSetSize',
        'workspace_id' => 'workspaceId'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'end_position' => 'setEndPosition',
        'folder' => 'setFolder',
        'items' => 'setItems',
        'parent_folders' => 'setParentFolders',
        'result_set_size' => 'setResultSetSize',
        'start_position' => 'setStartPosition',
        'total_set_size' => 'setTotalSetSize',
        'workspace_id' => 'setWorkspaceId'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'end_position' => 'getEndPosition',
        'folder' => 'getFolder',
        'items' => 'getItems',
        'parent_folders' => 'getParentFolders',
        'result_set_size' => 'getResultSetSize',
        'start_position' => 'getStartPosition',
        'total_set_size' => 'getTotalSetSize',
        'workspace_id' => 'getWorkspaceId'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['end_position'] = isset($data['end_position']) ? $data['end_position'] : null;
        $this->container['folder'] = isset($data['folder']) ? $data['folder'] : null;
        $this->container['items'] = isset($data['items']) ? $data['items'] : null;
        $this->container['parent_folders'] = isset($data['parent_folders']) ? $data['parent_folders'] : null;
        $this->container['result_set_size'] = isset($data['result_set_size']) ? $data['result_set_size'] : null;
        $this->container['start_position'] = isset($data['start_position']) ? $data['start_position'] : null;
        $this->container['total_set_size'] = isset($data['total_set_size']) ? $data['total_set_size'] : null;
        $this->container['workspace_id'] = isset($data['workspace_id']) ? $data['workspace_id'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        return true;
    }


    /**
     * Gets end_position
     * @return string
     */
    public function getEndPosition()
    {
        return $this->container['end_position'];
    }

    /**
     * Sets end_position
     * @param string $end_position The last position in the result set.
     * @return $this
     */
    public function setEndPosition($end_position)
    {
        $this->container['end_position'] = $end_position;

        return $this;
    }

    /**
     * Gets folder
     * @return \DocuSign\eSign\Model\WorkspaceItem
     */
    public function getFolder()
    {
        return $this->container['folder'];
    }

    /**
     * Sets folder
     * @param \DocuSign\eSign\Model\WorkspaceItem $folder
     * @return $this
     */
    public function setFolder($folder)
    {
        $this->container['folder'] = $folder;

        return $this;
    }

    /**
     * Gets items
     * @return \DocuSign\eSign\Model\WorkspaceItem[]
     */
    public function getItems()
    {
        return $this->container['items'];
    }

    /**
     * Sets items
     * @param \DocuSign\eSign\Model\WorkspaceItem[] $items 
     * @return $this
     */
    public function setItems($items)
    {
        $this->container['items'] = $items;

        return $this;
    }

    /**
     * Gets parent_folders
     * @return \DocuSign\eSign\Model\WorkspaceItem[]
     */
    public function getParentFolders()
    {
        return $this->container['parent_folders'];
    }

    /**
     * Sets parent_folders
     * @param \DocuSign\eSign\Model\WorkspaceItem[] $parent_folders 
     * @return $this
     */
    public function setParentFolders($parent_folders)
    {
        $this->container['parent_folders'] = $parent_folders;

        return $this;
    }

    /**
     * Gets result_set_size
     * @return string
     */
    public function getResultSetSize()
    {
        return $this->container['result_set_size'];
    }

    /**
     * Sets result_set_size
     * @param string $result_set_size The number of results returned in this response.
     * @return $this
     */
    public function setResultSetSize($result_set_size)
    {
        $this->container['result_set_size'] = $result_set_size;

        return $this;
    }

    /**
     * Gets start_position
     * @return string
     */
    public function getStartPosition()
    {
        return $this->container['start_position'];
    }

    /**
     * Sets start_position
     * @param string $start_position Starting position of the current result set.
     * @return $this
     */
    public function setStartPosition($start_position)
    {
        $this->container['start_position'] = $start_position;

        return $this;
    }

    /**
     * Gets total_set_size
     * @return string
     */
    public function getTotalSetSize()
    {
        return $this->container['total_set_size'];
    }

    /**
     * Sets total_set_size
     * @param string $total_set_size The total number of items available in the result set. This will always be greater than or equal to the value of the property returning the results in the in the response.
     * @return $this
     */
    public function setTotalSetSize($total_set_size)
    {
        $this->container['total_set_size'] = $total_set_size;

        return $this;
    }

    /**
     * Gets workspace_id
     * @return string
     */
    public function getWorkspaceId()
    {
        return $this->container['workspace_id'];
    }

    /**
     * Sets workspace_id
     * @param string $workspace_id The id of the workspace, always populated.
     * @return $this
     */
    public function setWorkspaceId($workspace_id)
    {
        $this->container['workspace_id'] = $workspace_id;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\DocuSign\eSign\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\DocuSign\eSign\ObjectSerializer::sanitizeForSerialization($this));
    }
}


