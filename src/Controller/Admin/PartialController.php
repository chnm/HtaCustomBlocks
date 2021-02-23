<?php
namespace HtaCustomBlocks\Controller\Admin;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;

class PartialController extends AbstractActionController
{
    public function pageSidebarAction() {
      $view = new ViewModel;
      $view->setTerminal(true);
      return $view;
    }
    
    public function pageOptionsAction() {
      $view = new ViewModel;
      $view->setTerminal(true);
      $form = new Form;
      $form->add([
        'name' => 'o:thumbnail[o:id]',
        'type' => 'Omeka\Form\Element\Asset',
      ]);
      $form->add([
        'name' => 'home_heading',
        'type' => 'Text',
      ]);
      $form->add([
        'name' => 'description',
        'type' => 'Text',
      ]);
      
      $view->setVariable('form', $form);
      return $view;      
    }
}