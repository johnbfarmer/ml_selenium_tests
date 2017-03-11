<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class HomePageTest extends BaseTest
{
    protected
        $uid = 'home page';

    protected function runTests()
    {
        $class_name = '\\Tests\\HomePage\\HomePage' . ucfirst(strtolower($this->usertype));
        $class = call_user_func([$class_name, 'autoExecute'], $this->parameters);
    }
}