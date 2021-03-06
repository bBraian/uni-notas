<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5f0833573db852893ee8234c0a9c13f8
{
    public static $files = array (
        '84ec00a50dfe9d09b9b15e53cdf42fc7' => __DIR__ . '/../..' . '/config.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Unisinos\\Notas\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Unisinos\\Notas\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit5f0833573db852893ee8234c0a9c13f8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit5f0833573db852893ee8234c0a9c13f8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit5f0833573db852893ee8234c0a9c13f8::$classMap;

        }, null, ClassLoader::class);
    }
}
