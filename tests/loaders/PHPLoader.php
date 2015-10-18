<?php

use G4MR\Configs\Loader\LoaderInterface;
use G4MR\Configs\Exceptions\ErrorLoadingFile;
use G4MR\Configs\Exceptions\ErrorReadingFile;
use G4MR\Configs\Filesystem\LeagueFilesystem;
use G4MR\Configs\Filesystem\FileSystemInterface;

class PHPLoader implements LoaderInterface
{
    private $directory;
    private $filesystem;

    public function __construct($directory, FileSystemInterface $filesystem = null)
    {
        //set directory
        $this->directory = $directory;
        
        //set file system
        if(empty($filesystem)) {
            $this->filesystem = new LeagueFilesystem($directory);
        } else {
            $this->filesystem = $filesystem;
        }
    }

    public function load($path)
    {
        //check if file exists
        if(!$this->filesystem->exists($path)) {
            throw new ErrorLoadingFile(sprintf("The file you were trying to load doesn't exist: %s", $path));
        }

        //create file path
        $file_path = sprintf("%s/%s", $this->directory, $path);

        //include config file
        $data = include $file_path;

        if(!is_array($data)) {
            throw new ErrorReadingFile(sprintf("Unable to parse PHP Array Data in : %s", $file_path));
        }

        return $data;
    }

    public function getExtension()
    {
        return 'php';
    }
}
