<?php
namespace G4MR\Configs\Loader;

use Symfony\Component\Yaml\Parser;
use G4MR\Configs\Exceptions\ErrorLoadingFile;
use G4MR\Configs\Exceptions\ErrorReadingFile;
use G4MR\Configs\Filesystem\LeagueFilesystem;
use G4MR\Configs\Filesystem\FileSystemInterface;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * @package G4MR\Configs\Loader
 */
class YamlLoader implements LoaderInterface
{
    /**
     * @var string
     */
    private $filesystem;

    /**
     * @var string
     */
    private $extension = 'yml';

    /**
     * @param string $directory
     */
    public function __construct($directory, FileSystemInterface $filesystem = null)
    {
        if(empty($filesystem)) {
            $this->filesystem = new LeagueFilesystem($directory);
        } else {
            $this->filesystem = $filesystem;
        }
    }

    /**
     * @param string $path
     */
    public function load($path)
    {
        //get full path
        $file_path = sprintf("%s%s", $this->filesystem->getDirectory(), $path);

        //check if file exists
        if(!$this->filesystem->exists($path)) {
            throw new ErrorLoadingFile(sprintf("The file you were trying to load doesn't exist: %s", $file_path));
        }

        if(($file_contents = $this->filesystem->read($path)) === false) {
            throw new ErrorReadingFile(sprintf("There was a problem trying to load this file: %s", $file_path));
        }

        //lets try parsing the YAML file
        $data = null;

        try {
            $data = (new Parser)->parse($file_contents);
        } catch (ParseException $e) {
            throw new ErrorReadingFile(sprintf("Unable to parse the YAML string: %s", $e->getMessage()));
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

}