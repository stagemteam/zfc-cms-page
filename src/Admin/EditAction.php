<?php

namespace Stagem\ZfcCmsPage\Action\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stagem\ZfcCmsPage\Form\Admin\ContentForm;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Zend\View\Model\ViewModel;
use Popov\ZfcForm\FormElementManager;

class EditAction
{
    /* @var CmsPageService */
    protected $contentService;

    /** @var FormElementManager */
    protected $fm;

    public function __construct(CmsPageService $contentService, FormElementManager $fm)
    {
        $this->contentService = $contentService;
        $this->fm = $fm;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $contentBlock = ($contentBlock = $this->contentService->find($id = (int) $request->getAttribute('id')))
            ? $contentBlock
            : $this->contentService->getObjectModel();

        /** @var ContentForm $form */
        $form = $this->fm->get(ContentForm::class);
        $form->bind($contentBlock);

        if ($request->getMethod() == 'POST') {
            $form->setData($request->getParsedBody());
            if ($form->isValid()) {
                $this->contentService->save($contentBlock);
            }
        }

        $view = new ViewModel([
            'form' => $form,
        ]);

        return $handler->handle($request->withAttribute(ViewModel::class, $view));
    }
}