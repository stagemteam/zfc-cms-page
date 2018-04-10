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
use Stagem\ZfcLang\LangHelper;
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

    /** @var LangHelper */
    protected $langHelper;

    protected $cmsPageGrid;

    protected $config;

    public function __construct(CmsPageService $cmsPageService, CmsPageGrid $cmsPageGrid, LangHelper $langHelper, CurrentHelper $currentHelper/*, array $config*/)
    {
        $this->cmsPageService = $cmsPageService;
        $this->cmsPageGrid = $cmsPageGrid;
        $this->currentHelper = $currentHelper;
        $this->langHelper = $langHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $lang = $this->langHelper->getCurrentLang();
        $cmsPages = $this->cmsPageService->getCmsPagesByLang($lang);

        $this->cmsPageGrid->init();
        $productDataGrid = $this->cmsPageGrid->getDataGrid();
        $productDataGrid->setDataSource($cmsPages);
        $productDataGrid->render();

        $response = $productDataGrid->getResponse();
        return $handler->handle($request->withAttribute(ViewModel::class, $response));
    }
}
