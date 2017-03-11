<?php 

namespace Tests\HomePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

use Tests\BaseTest;

class BaseHomePage extends BaseTest
{
    protected
        $uid = 'home page details';

    protected function runTests()
    {
        $this->log(get_called_class());
        $this->runUserTypeTests();
    }
}