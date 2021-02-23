<?php

namespace HtaCustomBlocks;

use Omeka\Module\AbstractModule;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\SharedEventManagerInterface;

class Module extends AbstractModule
{
    public function getConfig()
    {
      return include __DIR__ . '/config/module.config.php';
    }
}