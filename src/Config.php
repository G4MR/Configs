<?php
namespace G4MR\Configs;

use igorw;

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
     * @param Loader\LoaderInterface $loader
     */
    public function __construct(Loader\LoaderInterface $loader)
    {
        $this->loader = $loader;

        //set extension
        $this->setExtension($this->loader->getExtension());
    }

    public function setExtension($extension)
    {
        $this->config_file_extension = $extension;
    }

    /**
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
        $config_array_pieces = explode('.', $item);

        //lets get the file name if one exists
        $config_file = array_shift($config_array_pieces);
        if(empty($config_file)) {
            return $default;
        }

        //add extension to the config file path
        $config_file = sprintf("%s.%s", $config_file, $this->config_file_extension);

        //lets try loading the config file data
        $data = $this->loader->load($config_file);

        //if no array items exists return the full array
        if(empty($config_array_pieces)) {
            return $data;
        }

        //return default if data isn't an array
        if(!is_array($data)) {
            return $default;
        }

        //try getting item
        return igorw\get_in($data, $config_array_pieces, $default);
    }
}