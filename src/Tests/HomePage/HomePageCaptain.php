<?php 

namespace Tests\HomePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class HomePageCaptain extends BaseHomePage
{
    protected
        $uid = 'captain home page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}