<?php
namespace G4MR\Configs\Filesystem;

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * @package G4MR\Configs\Filesystem
 */
class LeagueFilesystem implements FileSystemInterface
{
    private $filesystem;

    public function __construct($directory, League\Flysystem\Adapter $adapter = null)
    {
        if(empty($adapter)) {
            $this->filesystem = new Filesystem(new Local($directory));
        } else {
            $this->filesystem = new Filesystem($adapter);
        }
    }

    /**
     * @param string $path
     * @return string
     */
    public function read($path)
    {
        return $this->filesystem->read($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function exists($path)
    {
        return $this->filesystem->has($path);
    }

    /**
     * @return Filesystem
     */
    public function getDirectory()
    {
        $adapter = $this->filesystem->getAdapter();

        return $adapter->getPathPrefix();   
    }
}