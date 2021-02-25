<?php
namespace HtaCustomBlocks\Controller\Admin;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Form\Form;

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
        'name' => 'alt_label',
        'type' => 'Text',
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