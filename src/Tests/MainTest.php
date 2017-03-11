<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class MainTest extends BaseTest
{
    protected
        $uid = 'main';

    protected function runTests()
    {
        HomePageTest::autoExecute($this->parameters);
        GamePageTest::autoExecute($this->parameters);
        ReportsPageTest::autoExecute($this->parameters);
    }
}