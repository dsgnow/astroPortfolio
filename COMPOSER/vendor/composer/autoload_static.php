<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbcd22bd49edd45a7a89f0172cfa7743a
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'ReCaptcha\\' => 10,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ReCaptcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/google/recaptcha/src/ReCaptcha',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'SimpleXLSX' => __DIR__ . '/..' . '/shuchkin/simplexlsx/src/SimpleXLSX.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbcd22bd49edd45a7a89f0172cfa7743a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbcd22bd49edd45a7a89f0172cfa7743a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbcd22bd49edd45a7a89f0172cfa7743a::$classMap;

        }, null, ClassLoader::class);
    }
}