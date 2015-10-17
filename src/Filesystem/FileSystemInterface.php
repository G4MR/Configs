<?php
namespace G4MR\Configs\Filesystem;

interface FileSystemInterface
{
    public function read($path);
    public function exists($path);
    public function getDirectory();
}