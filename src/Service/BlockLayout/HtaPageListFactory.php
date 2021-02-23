<?php
namespace HtaCustomBlocks\Service\BlockLayout;

use Interop\Container\ContainerInterface;
use HtaCustomBlocks\Site\BlockLayout\HtaPageList;
use Zend\ServiceManager\Factory\FactoryInterface;

class HtaPageListFactory implements FactoryInterface
{
    /**
     * Create the listOfPages block layout service.
     *
     * @param ContainerInterface $serviceLocator
     * @return ListOfPages
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        return new HtaPageList();
    }
}