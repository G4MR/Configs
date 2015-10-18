#G4MR\Configs

This is a simple library which allows you to load config files as array data
and accessing the data using dot-notation.  I made this library to simplify
the process of loading YAML config files with the ease of implementing
your own config loader.

# Composer

Install via [composer](https://packagist.org/packages/g4mr/configs) using `composer require g4mr/configs` 


## Example 1

    use G4MR\Configs\Config;
    use G4MR\Configs\Loaders\YamlLoader;

    $config = new Config(new YamlLoader(__DIR__ . '/config'));

    //loads ./config/database.yml as an array block
    $db_config = $config->get('database', false);
    if($db_config !== false) {
        echo $db_config['dbname'];
    }

## Example 2 - using the item object

    use G4MR\Configs\Config;
    use G4MR\Configs\Loaders\YamlLoader;

    $config = new Config(new YamlLoader(__DIR__ . '/config'));

    //example using stash (http://www.stashphp.com) caching
    $pool = new Stash\Pool();

    $db_stash   = $pool->getItem('db/config');
    $db_config  = $db_stash->get();

    if($db_stash->isMiss()) {
        $db_config = $config->getItem('database');
        $db_stash->set($db_config, 60 * 5); //cache data for 5 minutes
    }

    $dbname = $db_config->get('dbname', null);
    $dbuser = $db_config->get('username', null);
    $dbpass = $db_config->get('password', null);
    $dbhost = $db_config->get('host', 'localhost');

## Custom Loader

Check the tests folder for examples on how to implement your own config loader,