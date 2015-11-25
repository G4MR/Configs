<?php
namespace G4MR\Configs\Loader;

/**
 * @package G4MR\Configs\Loader
 */
interface LoaderInterface
{
    public function load($path);
    public function getExtension();
}