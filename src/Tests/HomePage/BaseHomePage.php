<?php 

namespace Tests\HomePage;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

use Tests\BasePageTest;

class BaseHomePage extends BasePageTest
{
    protected
        $uid = 'home page details',
        $link_text = 'Home';

    protected function runBaseTests()
    {
        $this->log('base page');
    }
}