<?php
namespace G4MR\Configs;

use igorw;

/**
 * @package G4MR\Configs
 */
class Config
{
    /**
     * @var Loader\LoaderInterface
     */
    private $loader;

    /**
     * @var string $default_extension
     */
    private $config_file_extension;

    /**
     * Pass loader interface which sets the config folder
     * for loading config files into array data.
     * @param Loader\LoaderInterface $loader
     */
    public function __construct(Loader\LoaderInterface $loader)
    {
        $this->loader = $loader;

        //set extension
        $this->setExtension($this->loader->getExtension());
    }

    /**
     * setExtension() - sets the file extension of the config
     * file that we are trying to load.
     * @var string $extension
     */
    public function setExtension($extension)
    {
        $this->config_file_extension = $extension;
    }

    /**
     * loadConfig() - allows the loader to parse a config file
     * and return the data as an array value
     * @param string $path
     * @return array
     */
    public function loadConfig($path)
    {
        //add extension to the config file
        $path = sprintf("%s.%s", $path, $this->config_file_extension);

        //lets try loading the config file data
        return $this->loader->load($path);
    }

    /**
     * get() - uses dot notation to set the config file name followed
     * by array key items based on their hierarchy in the array object
     * and attempts to return that array's item value else result to null
     * @param string $item dot notation config_file.array.item
     * @param mixed $default value if it doesn't exist
     * @return mixed
     */
    public function get($item, $default = null)
    {
        //why would you send an empty value?
        if(empty($item) || !is_string($item)) {
            return $default;
        }

        //break item data into dot notation
        $item_pieces = explode('.', $item);

        //get config file name
        $config = array_shift($item_pieces);

        //attempt to load data
        $data = $this->loadConfig($config);

        //return default if data isn't an array
        if(!is_array($data)) {
            return $default;
        }

        if(empty($item_pieces)) {
            return $data;
        }

        //create item object
        $item = new Item($data);

        //attempt to return 
        return $item->get(implode('.', $item_pieces), $default);
    }

    /**
     * getItem() - loads the config file and returns an item object
     * so if a user wants they could cache the item object and still
     * be able to access all the config data without multiple file calls
     * @param string $config - config file name
     * @return mixed
     */
    public function getItem($config)
    {
        //why would you send an empty value?
        if(empty($config) || !is_string($config)) {
            return false;
        }

        $data = $this->loadConfig($config);

        //no config data available
        if(!is_array($data)) {
            return false;
        }

        //return item object
        return new Item($data);
    }
}