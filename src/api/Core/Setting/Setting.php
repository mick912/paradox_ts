<?php
namespace Core\Setting;

use JsonSerializable;

class Setting implements \ArrayAccess, JsonSerializable
{
    /**
     * List of all the settings.
     *
     * @var array
     */
    private array $settings = [];

    private array $defaults = [
        'db' => [
            'host' => 'localhost',
            'user' => '',
            'pass' => '',
            'name' => '',
            'driver' => 'mongodb'
        ]
    ];


    /**
     * Create a new fluent container instance.
     *
     * @internal param array|object $attributes
     */
    public function __construct()
    {
        $commonSettings = DIR_SETTING . 'common.php';
        if (file_exists($commonSettings)) {
            $this->settings = array_merge($this->defaults, require($commonSettings));
        }else{
            throw new \LogicException('Common configuration file not found in :'.DIR_SETTING);
        }
    }

    /**
     * Creates a new setting.
     *
     * @param array|string $setting ARRAY of settings and values.
     * @param null $value Value of setting if the 1st argument is a string.
     * @return Setting
     */
    public function setParam($setting, $value = null)
    {
        if (is_string($setting))
        {
            $this->settings[$setting] = $value;
        }
        else
        {
            foreach ($setting as $key => $value)
            {
                $this->settings[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * Get a setting and its value.
     *
     * @param mixed $key STRING name of the setting or ARRAY name of the setting..
     * @return mixed Returns the value of the setting, which can be a STRING, ARRAY, BOOL or INT.
     */
    public function getParam($key)
    {
        if (is_array($key)) {
            return isset($this->settings[$key[0]][$key[1]]) ? $this->settings[$key[0]][$key[1]] : trigger_error('Missing Param: ' . $key[0] . '][' . $key[1], E_USER_ERROR);
        } else {
            return isset($this->settings[$key]) ? $this->settings[$key] : trigger_error('Missing Param: ' . $key, E_USER_ERROR);
        }
    }

    /**
     * Checks to see if a setting exists or not.
     *
     * @param string $key Name of the setting.
     * @return bool TRUE it exists, FALSE if it does not.
     */
    public function isSetting(string $key): bool
    {
        return isset($this->settings[$key]);
    }

    /**
     * Unset an param via key.
     *
     * @param  string  $key
     * @return void
     */
    public function unsetParam($key): void
    {
        unset($this->settings[$key]);
    }


    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->settings;
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $iOptions
     * @return string
     */
    public function toJson($iOptions = 0): string
    {
        return json_encode($this->jsonSerialize(), $iOptions);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->isSetting($offset);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->getParam($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->setParam($offset, $value);
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->settings[$offset]);
    }

}

