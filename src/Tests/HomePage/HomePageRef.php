<?php 

namespace Tests\HomePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class HomePageRef extends BaseHomePage
{
    protected
        $uid = 'ref home page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}