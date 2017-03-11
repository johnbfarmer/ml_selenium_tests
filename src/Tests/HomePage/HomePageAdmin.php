<?php 

namespace Tests\HomePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class HomePageAdmin extends BaseHomePage
{
    protected
        $uid = 'admin home page';

    protected function runTests()
    {
        $this->log(get_called_class());
    }
}