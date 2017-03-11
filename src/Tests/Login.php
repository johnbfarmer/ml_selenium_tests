<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class Login extends BaseTest
{
    protected
        $uid = 'login';

    protected function runTests()
    {
        $username = $this->username;
        $password = $this->password;
        $driver = $this->driver;

        $driver->get($this->base_url . '/login');

        $driver->wait(3);
        $this->driver->wait(10, 1000)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::id('username')
            )
        );
        
        // fill in the login form
        try {
            $link = $driver->findElement(
                WebDriverBy::id('username')
            );
        } catch (\Exception $e) {
            if (!$link) {
                $driver->close();
                $this->error('no login box found on ' . $this->base_url);
            }
        }
        $link->sendKeys($username);

        $link = $driver->findElement(
            WebDriverBy::id('password')
        );
        $link->sendKeys($password);

        $link = $driver->findElement(
            WebDriverBy::cssSelector('form')
        );
        $link->submit();
        $this->log('login submitted');
        $driver->wait(3);
        $this->driver->wait(10, 1000)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::id('mainPar')
            )
        );
        $current_url = $driver->getCurrentURL();
        $path_parts = explode('/', parse_url($current_url, PHP_URL_PATH));
        $path = $path_parts[count($path_parts) - 1];
        $this->log('path now ' . $path);
        if ($path === 'login') {
            $this->error('login failed');
            $driver->close();
            exit;
        }
    }
}