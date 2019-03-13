<?php
/**
 * FeatureSet
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
 * FeatureSet Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class FeatureSet implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'featureSet';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'currency_feature_set_prices' => '\DocuSign\eSign\Model\CurrencyFeatureSetPrice[]',
        'envelope_fee' => 'string',
        'feature_set_id' => 'string',
        'fixed_fee' => 'string',
        'is21_cfr_part11' => 'string',
        'is_active' => 'string',
        'is_enabled' => 'string',
        'name' => 'string',
        'seat_fee' => 'string'
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
        'currency_feature_set_prices' => 'currencyFeatureSetPrices',
        'envelope_fee' => 'envelopeFee',
        'feature_set_id' => 'featureSetId',
        'fixed_fee' => 'fixedFee',
        'is21_cfr_part11' => 'is21CFRPart11',
        'is_active' => 'isActive',
        'is_enabled' => 'isEnabled',
        'name' => 'name',
        'seat_fee' => 'seatFee'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'currency_feature_set_prices' => 'setCurrencyFeatureSetPrices',
        'envelope_fee' => 'setEnvelopeFee',
        'feature_set_id' => 'setFeatureSetId',
        'fixed_fee' => 'setFixedFee',
        'is21_cfr_part11' => 'setIs21CfrPart11',
        'is_active' => 'setIsActive',
        'is_enabled' => 'setIsEnabled',
        'name' => 'setName',
        'seat_fee' => 'setSeatFee'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'currency_feature_set_prices' => 'getCurrencyFeatureSetPrices',
        'envelope_fee' => 'getEnvelopeFee',
        'feature_set_id' => 'getFeatureSetId',
        'fixed_fee' => 'getFixedFee',
        'is21_cfr_part11' => 'getIs21CfrPart11',
        'is_active' => 'getIsActive',
        'is_enabled' => 'getIsEnabled',
        'name' => 'getName',
        'seat_fee' => 'getSeatFee'
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
        $this->container['currency_feature_set_prices'] = isset($data['currency_feature_set_prices']) ? $data['currency_feature_set_prices'] : null;
        $this->container['envelope_fee'] = isset($data['envelope_fee']) ? $data['envelope_fee'] : null;
        $this->container['feature_set_id'] = isset($data['feature_set_id']) ? $data['feature_set_id'] : null;
        $this->container['fixed_fee'] = isset($data['fixed_fee']) ? $data['fixed_fee'] : null;
        $this->container['is21_cfr_part11'] = isset($data['is21_cfr_part11']) ? $data['is21_cfr_part11'] : null;
        $this->container['is_active'] = isset($data['is_active']) ? $data['is_active'] : null;
        $this->container['is_enabled'] = isset($data['is_enabled']) ? $data['is_enabled'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['seat_fee'] = isset($data['seat_fee']) ? $data['seat_fee'] : null;
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
     * Gets currency_feature_set_prices
     * @return \DocuSign\eSign\Model\CurrencyFeatureSetPrice[]
     */
    public function getCurrencyFeatureSetPrices()
    {
        return $this->container['currency_feature_set_prices'];
    }

    /**
     * Sets currency_feature_set_prices
     * @param \DocuSign\eSign\Model\CurrencyFeatureSetPrice[] $currency_feature_set_prices A complex type that contains alternate currency values that are configured for this plan feature set.
     * @return $this
     */
    public function setCurrencyFeatureSetPrices($currency_feature_set_prices)
    {
        $this->container['currency_feature_set_prices'] = $currency_feature_set_prices;

        return $this;
    }

    /**
     * Gets envelope_fee
     * @return string
     */
    public function getEnvelopeFee()
    {
        return $this->container['envelope_fee'];
    }

    /**
     * Sets envelope_fee
     * @param string $envelope_fee 
     * @return $this
     */
    public function setEnvelopeFee($envelope_fee)
    {
        $this->container['envelope_fee'] = $envelope_fee;

        return $this;
    }

    /**
     * Gets feature_set_id
     * @return string
     */
    public function getFeatureSetId()
    {
        return $this->container['feature_set_id'];
    }

    /**
     * Sets feature_set_id
     * @param string $feature_set_id A unique ID for the feature set.
     * @return $this
     */
    public function setFeatureSetId($feature_set_id)
    {
        $this->container['feature_set_id'] = $feature_set_id;

        return $this;
    }

    /**
     * Gets fixed_fee
     * @return string
     */
    public function getFixedFee()
    {
        return $this->container['fixed_fee'];
    }

    /**
     * Sets fixed_fee
     * @param string $fixed_fee 
     * @return $this
     */
    public function setFixedFee($fixed_fee)
    {
        $this->container['fixed_fee'] = $fixed_fee;

        return $this;
    }

    /**
     * Gets is21_cfr_part11
     * @return string
     */
    public function getIs21CfrPart11()
    {
        return $this->container['is21_cfr_part11'];
    }

    /**
     * Sets is21_cfr_part11
     * @param string $is21_cfr_part11 When set to **true**, indicates that this module is enabled on the account.
     * @return $this
     */
    public function setIs21CfrPart11($is21_cfr_part11)
    {
        $this->container['is21_cfr_part11'] = $is21_cfr_part11;

        return $this;
    }

    /**
     * Gets is_active
     * @return string
     */
    public function getIsActive()
    {
        return $this->container['is_active'];
    }

    /**
     * Sets is_active
     * @param string $is_active 
     * @return $this
     */
    public function setIsActive($is_active)
    {
        $this->container['is_active'] = $is_active;

        return $this;
    }

    /**
     * Gets is_enabled
     * @return string
     */
    public function getIsEnabled()
    {
        return $this->container['is_enabled'];
    }

    /**
     * Sets is_enabled
     * @param string $is_enabled Specifies whether the feature set is actively enabled as part of the plan.
     * @return $this
     */
    public function setIsEnabled($is_enabled)
    {
        $this->container['is_enabled'] = $is_enabled;

        return $this;
    }

    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     * @param string $name 
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets seat_fee
     * @return string
     */
    public function getSeatFee()
    {
        return $this->container['seat_fee'];
    }

    /**
     * Sets seat_fee
     * @param string $seat_fee An incremental seat cost for seat-based plans. Only valid when isEnabled for the feature set is set to true.
     * @return $this
     */
    public function setSeatFee($seat_fee)
    {
        $this->container['seat_fee'] = $seat_fee;

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


