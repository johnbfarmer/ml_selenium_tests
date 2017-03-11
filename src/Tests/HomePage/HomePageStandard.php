<?php 

namespace Tests\HomePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class HomePageStandard extends BaseHomePage
{
    protected
        $uid = 'standard home page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}