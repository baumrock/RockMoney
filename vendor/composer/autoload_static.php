<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1c82c03a66242b88ff53ed52a584b264
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Money\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Money\\' => 
        array (
            0 => __DIR__ . '/..' . '/moneyphp/money/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1c82c03a66242b88ff53ed52a584b264::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1c82c03a66242b88ff53ed52a584b264::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1c82c03a66242b88ff53ed52a584b264::$classMap;

        }, null, ClassLoader::class);
    }
}
