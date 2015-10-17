= G4MR\Configs

This is a simple library which allows you to load config files as array data
and accessing the data using dot-notation.  I made this library to simplify
the process of loading YAML config files with the ease of implementing
your own config loader.

== Example

    use G4MR\Configs\Config;
    use G4MR\Configs\Loaders\YamlLoader;

    $config = new Config(new YamlLoader(__DIR__ . '/config'));

    //loads ./config/database.yml as an array block
    $dbconfig = $config->get('database', false);
    if($dbconfig !== false) {
        echo $dbconfig['dbname'];
    }

Check the tests folder for examples on how to implement your own config loader,

== TODO

- Add in a method which performs `get('filename')` and returns
an object so we can perform multiple `getItem()` calls without
reloading the same file over.  Which we could then cache said
object for performance if needed.