<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit29f249eaf446354616af86f8eeac1c8a
{
    public static $files = array (
        '89ff252b349d4d088742a09c25f5dd74' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/plugin-update-checker.php',
        'f7d520a7dfd4979ca7d4b88dfbc5d7f5' => __DIR__ . '/..' . '/rilwis/meta-box/meta-box.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PostTypes\\' => 10,
        ),
        'F' => 
        array (
            'FredBradley\\CranleighCulturePlugin\\' => 35,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PostTypes\\' => 
        array (
            0 => __DIR__ . '/..' . '/jjgrainger/posttypes/src',
        ),
        'FredBradley\\CranleighCulturePlugin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'WeDevs_Settings_API' => __DIR__ . '/..' . '/tareq1988/wordpress-settings-api-class/src/class.settings-api.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit29f249eaf446354616af86f8eeac1c8a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit29f249eaf446354616af86f8eeac1c8a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit29f249eaf446354616af86f8eeac1c8a::$classMap;

        }, null, ClassLoader::class);
    }
}
