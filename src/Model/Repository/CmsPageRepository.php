<?php

namespace Stagem\ZfcCmsPage\Model\Repository;

class CmsPageRepository extends \Doctrine\ORM\EntityRepository
{
    protected $_alias = 'cms_page';

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCmsPages()
    {
        $l = 'lang';

        $qb = $this->createQueryBuilder($this->_alias)
            ->leftJoin($this->_alias . '.lang', $l);
        return $qb;
    }

    /**
     * @param $lang
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCmsPagesByLang($lang) {
        $qb = $this->getCmsPages();

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq($this->_alias . '.lang', '?1')
            )
        );

        $qb->setParameter(1, $lang);

        return $qb;
    }

    /**
     * @param $url
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCmsPagesByUrl($url) {
        $qb = $this->getCmsPages();

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq($this->_alias . '.pageUrl', '?1')
            )
        );

        $qb->setParameter(1, $url);

        return $qb;
    }

    /**
     * @param $url
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCmsPageByLangAndUrl($url, $lang) {
        $qb = $this->getCmsPages();

        $qb->where(
            $qb->expr()->andX(
                $qb->expr()->eq($this->_alias . '.pageUrl', '?1'),
                $qb->expr()->eq($this->_alias . '.lang', '?2')
            )
        );

        $qb->setParameters([1 => $url, 2 => $lang]);

        return $qb;
    }

}