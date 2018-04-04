<?php
/**
 *
 * @category Stagem
 * @package Stagem_Question
 * @author Vlad Kozak <vlad.gem.typ@gmail.com>
 * @datetime: 03.01.2018 14:14
 */

namespace Stagem\ZfcCmsPage\Service;

use Popov\ZfcCore\Service\DomainServiceAbstract;
use Stagem\Question\Model\Question as Question;
use Stagem\Question\Model\Repository\QuestionRepository;
use Stagem\ZfcCmsPage\Model\CmsPage;

/**
 * Class CMSBlockService
 *
 * @method QuestionRepository getRepository()
 */
class CmsPageService extends DomainServiceAbstract
{
    protected $entity = CmsPage::class;

    public function save(CmsPage $cmsPage)
    {
        $om = $this->getObjectManager();
        if (!$om->contains($cmsPage)) {
            $om->persist($cmsPage);
        }
        $om->flush();
    }

    /**
     * @param $parsedBody
     * @return array
     */
    public function getCollectionFromParsedBody($parsedBody) {
        $collection = [];
        foreach ($parsedBody['cmsPages'] as $item) {
            $cmsBlock = $this->getObjectModel();
            foreach (array_keys($item) as $value) {
                $method = 'set' . ucfirst($value);
                $cmsBlock->{$method}($item[$value]);
            }
            $collection[] = $cmsBlock;
        }

        return $collection;
    }

    /**
     * @return mixed
     */
    public function getCmsPagesByUrl($url) {
        return $this->getRepository()->getCmsPagesByUrl($url)->getQuery()->getResult();

    }

    /**
     * @return mixed
     */
    public function getCmsPagesByLang($lang) {
        return $this->getRepository()->getCmsPagesByLang($lang);

    }

}