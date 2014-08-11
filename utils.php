<?php

function setupAutoLoad()
{
  if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    //SPL autoloading was introduced in PHP 5.1.2
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
      spl_autoload_register('FBLibAutoload', true, true);
    } else {
      spl_autoload_register('FBLibAutoload');
    }
  } else {
    /**
     * Fall back to traditional autoload for old PHP versions
     * @param string $classname The name of the class to load
     */
    function __autoload($classname)
    {
      FBLibAutoload($classname);
    }
  }
}

function FBLibAutoload($classname)
{
  //Can't use __DIR__ as it's only in PHP 5.3+
  $filename = dirname(__FILE__).DIRECTORY_SEPARATOR."vendor/facebook/php-sdk-v4/src/${classname}.php";
  $filename = str_replace('\\', '/', $filename);

  if (is_readable($filename)) {
    require $filename;
  }
}

?>