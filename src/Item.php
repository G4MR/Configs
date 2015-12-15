<?php
namespace G4MR\Configs;

use igorw;

/**
 * @package G4MR\Configs
 */
class Item
{
    /**
     * @var array $data
     */
    private $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Gets item from array if it exists else return default value
     * @param string $item dot notation config_file.array.item
     * @param mixed $default value if it doesn't exist
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if(!is_string($key) || empty($key)) {
            return $default;
        }

        //split string into array
        $item_pieces = explode('.', $key);

        //let igorw check if array item exists
        return igorw\get_in($this->data, $item_pieces, $default);
    }

    /**
     * Set key:value pair and overwite if one exists
     * @param string
     * @param mixed
     */
    public function set($key, $value)
    {
        
        if(is_array($key) || empty($key)) {
            throw new \Exception('Key should be a string value');
        }

        //split string into array
        $item_pieces = explode('.', $key);

        if(count($item_pieces) == 1) {
            $this->data[current($item_pieces)] = $value;
            return;
        }

        $current_array =& $this->data[current($item_pieces)];
        array_shift($item_pieces);

        //loop through pieces
        foreach($item_pieces as $piece) {
            $current_array =& $current_array[$piece];
        }

        $current_array = $value;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->data;
    }

    /**
     * alias for `set()`
     * @param string
     * @param mixed
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * alias for `get()`
     * @param string
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
}