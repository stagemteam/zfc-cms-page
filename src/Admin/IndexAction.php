<?php

namespace Stagem\ZfcCmsPage\Action\Admin;

use Stagem\ZfcCmsPage\Block\Grid\ContentGrid;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Popov\ZfcCurrent\CurrentHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;
use Zend\View\Model\ViewModel;

class IndexAction implements MiddlewareInterface, RequestMethodInterface
{
    /**
     * @var CmsPageService
     */
    protected $contentService;

    /**
     * @var CurrentHelper
     */
    protected $currentHelper;

    protected $contentGrid;

    protected $config;

    public function __construct(CmsPageService $contentService, ContentGrid $contentGrid, CurrentHelper $currentHelper/*, array $config*/)
    {
        $this->contentService = $contentService;
        $this->contentGrid = $contentGrid;
        $this->currentHelper = $currentHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $contentBlocks = $this->contentService->getAllContents();

        $this->contentGrid->init();
        $productDataGrid = $this->contentGrid->getDataGrid();
        $productDataGrid->setDataSource($contentBlocks);
        $productDataGrid->render();

        $response = $productDataGrid->getResponse();
        return $handler->handle($request->withAttribute(ViewModel::class, $response));
    }
}

