<?php

namespace HtaCustomBlocks;

use Omeka\Module\AbstractModule;
use Laminas\EventManager\Event;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\SharedEventManagerInterface;

class Module extends AbstractModule
{
    public function getConfig()
    {
      return include __DIR__ . '/config/module.config.php';
    }
}