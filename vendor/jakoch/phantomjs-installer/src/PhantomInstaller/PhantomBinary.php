<?php

namespace PhantomInstaller;

class PhantomBinary
{
    const BIN = '/Library/WebServer/Documents/kpi/bin/phantomjs';
    const DIR = '/Library/WebServer/Documents/kpi/bin';

    public static function getBin() {
        return self::BIN;
    }

    public static function getDir() {
        return self::DIR;
    }
}
