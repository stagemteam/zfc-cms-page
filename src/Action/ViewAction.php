<?php
/**
 * @category Stagem
 * @package Stagem_Content
 * @author Kozak Vlad <vlad.gem.typ@gmail.com>
 * @datetime: 19.03.18 16:43
 */

namespace Stagem\ZfcCmsPage\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Zend\View\Model\ViewModel;

class ViewAction implements MiddlewareInterface, RequestMethodInterface
{
    /** @var CmsPageService */
    protected $cmsPageService;

    public function __construct(CmsPageService $cmsPageService)
    {
        $this->cmsPageService = $cmsPageService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $lang = $request->getAttribute('langObject');
        $url = $request->getAttribute('more');
        $cmsPage = $this->cmsPageService->getCmsPageByLangAndUrl($url, $lang);

        $view = new ViewModel([
            'cmsPage' => $cmsPage,
        ]);

        return $handler->handle($request->withAttribute(ViewModel::class, $view));

    }
}