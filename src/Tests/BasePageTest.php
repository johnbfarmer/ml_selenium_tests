<?php 

namespace Tests;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BasePageTest extends BaseTest
{
    protected
        $uid = 'page details',
        $link_text = '';

    protected function runTests()
    {
        try {
            $this->driver->wait(2, 1000)->until(
                WebDriverExpectedCondition::presenceOfElementLocated(
                    WebDriverBy::linkText($this->link_text)
                )
            );

            $link = $this->driver->findElement(
                WebDriverBy::linkText($this->link_text)
            );
        } catch (\Exception $e) {
            return $this->handleLinkNotFound();
        }

        $link->click();

        $this->runBaseTests();
        $this->runUserTypeTests();
    }

    protected function handleLinkNotFound()
    {
        $this->error('Missing Link ' . $this->link_text);
    }
}