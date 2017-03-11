<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class GamePageTest extends BaseTest
{
    protected
        $uid = 'game page';

    protected function runTests()
    {
        $class_name = '\\Tests\\GamePage\\GamePage' . ucfirst(strtolower($this->usertype));
        $class = call_user_func([$class_name, 'autoExecute'], $this->parameters);
    }
}