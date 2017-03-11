<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;

class Logout extends BaseTest
{
    protected
        $uid = 'logout';

    protected function runTests()
    {
        $driver = $this->driver;

        $driver->get($this->base_url . '/logoff');
    }
}