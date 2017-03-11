<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ReportsPageTest extends BaseTest
{
    protected
        $uid = 'reports page';

    protected function runTests()
    {
        $class_name = '\\Tests\\ReportsPage\\ReportsPage' . ucfirst(strtolower($this->usertype));
        $class = call_user_func([$class_name, 'autoExecute'], $this->parameters);
    }
}