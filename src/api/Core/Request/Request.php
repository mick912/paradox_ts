<?php
namespace Core\Request;


class Request implements IRequest
{
    /**
     * List of all the requests ($_GET, $_POST, $_FILES etc...)
     * @var array
     */
    private array $data = [];
    
    /**
     * @var string
     */
    private string $httpMethod = '';
    
    public function __construct()
    {
        $this->httpMethod = ((isset($_REQUEST['method']) && in_array($_REQUEST['method'], ['GET', 'POST', 'DELETE', 'PUT']))
            ? $_REQUEST['method']
            : $_SERVER['REQUEST_METHOD']);
        $this->httpMethod === 'PUT'
            ? parse_str(file_get_contents('php://input', false, null, -1, $_SERVER['CONTENT_LENGTH']), $_PUT)
            : $_PUT = [];
        $this->data = $this->trimData(array_merge($_GET, $_POST, $_FILES, $_PUT));
    }

    public function isPost() : bool
    {
        return $this->httpMethod === 'POST';
    }

    /**
     * Retrieve value from request.
     *
     * @param string $name name of argument
     * @param mixed $def default value
     * @return mixed data value
     */
    function get(string $name = '', $def = '')
    {
        return $this->data[$name] ?? $def;
    }

    /**
     * Set a request manually.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, mixed $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Get all the requests.
     *
     * @return array
     */
    public function getData(): array
    {
        return (array)$this->data;
    }


    /**
     * Trims params and strip slashes if magic_quotes_gpc is set.
     *
     * @param mixed $data request params
     * @return mixed trimmed params.
     */
    private function trimData($data)
    {
        if (is_array($data)) {
            return array_map(array(&$this, 'trimData'), $data);
        }
        return trim($data);
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
        return isset($this->data[$offset]);
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
        return $this->get($offset);
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
        $this->data[$offset] = $value;
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
        unset($this->data[$offset]);
    }

    public function post(string $key, $def='')
    {
        return $_POST[$key] ?? $def;
    }

    public function getUri() : string
    {
        return parse_url($_SERVER['REQUEST_URI'])['path'];
    }

    public function getMethod() : string
    {
        return $this->httpMethod;
    }

}