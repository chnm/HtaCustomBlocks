<?php
namespace HtaCustomBlocks\Site\BlockLayout;

use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Entity\SitePageBlock;
use Omeka\Stdlib\ErrorStore;
use Laminas\Form\Element\Hidden;
use Laminas\View\Renderer\PhpRenderer;

class HtaPageList extends AbstractBlockLayout
{
    
    public function prepareForm(PhpRenderer $view) 
    {
      $view->headScript()->appendFile($view->assetUrl('js/hta-custom-blocks.js', 'HtaCustomBlocks'));
      $view->headScript()->appendFile($view->assetUrl('js/asset-form.js', 'Omeka'));
      $view->headLink()->appendStylesheet($view->assetUrl('css/hta-custom-blocks.css', 'HtaCustomBlocks'));
      $view->headLink()->appendStylesheet($view->assetUrl('css/asset-form.css', 'Omeka'));
    }

    public function getLabel()
    {
      return 'HtA: Page list'; //@translate
    }
    
    public function onHydrate(SitePageBlock $block, ErrorStore $errorStore)
    {
        $data = $block->getData();
        $block->setData($data);
    }
    
    public function form(PhpRenderer $view, SiteRepresentation $site, SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        $escape = $view->plugin('escapeHtml');
        $html = '';
        $siteId = $site->id();
        $apiUrl = $site->apiUrl();
        $pages = ($block) ? $block->data() : '';
        $assets = [];
        if ($pages !== '') {
          foreach ($pages as $key => $page) {
            if (isset($page['site_page']['media']) && ($page['site_page']['media'] !== '')) {
              $assetId = $page['site_page']['media'];
              $asset = $view->api()->read('assets', $assetId)->getContent();
              $assets[$assetId] = $asset;
            }
          }
        }
        return $view->partial('common/block-layout/list-of-pages', [
          'block' => $block,
          'siteId' => $siteId,
          'apiUrl' => $apiUrl,
          'pages' => $pages,
          'assets' => $assets,
        ]);
    }
    
    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        $pages = $block->data();
        $pages = ($block) ? $block->data() : '';
        $assets = [];
        if ($pages !== '') {
          foreach ($pages as $key => $page) {
            if (isset($page['site_page']['media']) && ($page['site_page']['media'] !== '')) {
              $assetId = $page['site_page']['media'];
              $asset = $view->api()->read('assets', $assetId)->getContent();
              $assets[$assetId] = $asset;
            }
          }
        }
        return $view->partial('hta-custom-blocks/site/list-of-pages', [
          'pages' => $pages,
          'assets' => $assets,
        ]);
    }
}