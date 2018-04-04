<?php

namespace Stagem\ZfcCmsPage\Action\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stagem\ZfcCmsBlock\Service\CmsBlockService;
use Stagem\ZfcCmsPage\Form\Admin\CmsPageForm;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\View\Model\ViewModel;
use Popov\ZfcForm\FormElementManager;
use Zend\Diactoros\Response\RedirectResponse;
class CreateAction
{
    /* @var CmsPageService */
    protected $cmsPageService;

    /* @var UrlHelper */
    protected $urlHelper;

    /** @var FormElementManager */
    protected $fm;

    public function __construct(CmsPageService $cmsPageService, UrlHelper $urlHelper, FormElementManager $fm)
    {
        $this->cmsPageService = $cmsPageService;
        $this->urlHelper = $urlHelper;
        $this->fm = $fm;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->fm->get(CmsPageForm::class);

        if ($request->getMethod() == 'POST') {

            $collection = $this->cmsPageService->getCollectionFromParsedBody($request->getParsedBody());

            /** @var \Zend\Form\Element\Collection $base */
            $base = $form->getBaseFieldset();
            $base->setObject($collection);

            $method = new \ReflectionMethod(get_class($form), 'extract');
            $method->setAccessible(true);
            $data = $method->invoke($form);

            $form->populateValues($data, true);

            $postData = $request->getParsedBody();
            $form->setData($postData);
            if ($form->isValid()) {
                //$this->cmsBlockService->saveAllCmsBlocks($cmsBlocksData, $postData);
                $this->cmsPageService->getObjectManager()->flush();

                return new RedirectResponse($this->urlHelper->generate('admin/default',
                    [
                        'resource' => 'cms-page',
                        'action' => 'index',
                        'lang' => $request->getAttribute('lang')
                    ]
                ));
            }
        }

        $view = new ViewModel([
            'form' => $form,
        ]);

        return $handler->handle($request->withAttribute(ViewModel::class, $view));
    }
}