<?php
/**
 * @category Stagem
 * @package Stagem_Question
 * @author Kozak Vlad <vlad.gem.typ@gmail.com>
 * @datetime: 04.01.2018 16:14
 */

namespace Stagem\ZfcCmsPage\Form\Admin;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Stagem\ZfcCmsBlock\Model\CmsBlock;
use Stagem\ZfcCmsPage\Model\CmsPage;
use Stagem\ZfcLang\Model\Lang;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;
use Stagem\ZfcTranslator\TranslatorAwareTrait;
use Zend\I18n\Translator\TranslatorAwareInterface;

class CmsPageFieldset extends Fieldset implements InputFilterProviderInterface, ObjectManagerAwareInterface, TranslatorAwareInterface
{
    use ProvidesObjectManager;
    use TranslatorAwareTrait;

    protected $entity = CmsPage::class;

    public function getObjectName()
    {
        return $this->entity;
    }

    public function init()
    {
        $this->setName('cmsPage');

        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
        ]);

        $this->add([
            'name' => 'title',
            'attributes' => [
                'required' => 'required',
            ],
            'options' => [
                'label' => $this->translate('Title')
            ]
        ]);

        $this->add([
            'name' => 'pageUrl',
            'attributes' => [
                'required' => 'required',
            ],
            'options' => [
                'label' =>  $this->translate('Page Url')
            ]
        ]);

        $this->add([
            'name' => 'content',
            'type' => 'textarea',
            'attributes' => [
                'placeholder' => $this->translate('Content')
            ],
            'options' => [
                'label' =>  $this->translate('Content')
            ]
        ]);

        $this->add([
            'name' => 'sortOrder',
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        $this->add([
            'name' => 'metaKeywords',
            'type' => 'textarea',
            'attributes' => [
                'placeholder' =>  $this->translate('Meta Keywords')
            ],
            'options' => [
                'label' =>  $this->translate('Meta Keywords')
            ]
        ]);

        $this->add([
            'name' => 'metaDescription',
            'type' => 'textarea',
            'attributes' => [
                'placeholder' => $this->translate('Meta Description')
            ],
            'options' => [
                'label' => $this->translate('Meta Description')
            ]
        ]);

        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'lang',
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class' => Lang::class,
                'property' => 'name',
                'label'    => $this->translate('Choose language'),
                //'is_method' => true,
                /*'find_method' => [
                    'name' => 'findServiceByServiceCategoryMnemo',
                    'params' => [
                        'criteria' => ['orthopedic'],
                    ],
                ],*/
            ],
        ]);
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [];
    }
}
