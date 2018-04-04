<?php

namespace Stagem\ZfcCmsPage\Action\Admin;

use Stagem\ZfcCmsBlock\Service\CmsBlockService;
use Popov\ZfcCurrent\CurrentHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;
use Stagem\ZfcCmsPage\Block\Grid\CmsPageGrid;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Zend\View\Model\ViewModel;

class IndexAction implements MiddlewareInterface, RequestMethodInterface
{
    /**
     * @var CmsBlockService
     */
    protected $cmsPageService;

    /**
     * @var CurrentHelper
     */
    protected $currentHelper;

    protected $cmsPageGrid;

    protected $config;

    public function __construct(CmsPageService $cmsPageService, CmsPageGrid $cmsPageGrid, CurrentHelper $currentHelper/*, array $config*/)
    {
        $this->cmsPageService = $cmsPageService;
        $this->cmsPageGrid = $cmsPageGrid;
        $this->currentHelper = $currentHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $lang = $request->getAttribute('langObject');
        $cmsPages = $this->cmsPageService->getCmsPagesByLang($lang);

        $this->cmsPageGrid->init();
        $productDataGrid = $this->cmsPageGrid->getDataGrid();
        $productDataGrid->setDataSource($cmsPages);
        $productDataGrid->render();

        $response = $productDataGrid->getResponse();
        return $handler->handle($request->withAttribute(ViewModel::class, $response));
    }
}

