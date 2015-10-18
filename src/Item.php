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
     * @return array
     */
    public function getAll()
    {
        return $this->data;
    }
}