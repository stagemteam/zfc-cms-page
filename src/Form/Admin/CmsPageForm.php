<?php
namespace Stagem\ZfcCmsPage\Form\Admin;

use Zend\Form\Form;
use Stagem\ZfcTranslator\TranslatorAwareTrait;
use Zend\I18n\Translator\TranslatorAwareInterface;

class CmsPageForm extends Form implements TranslatorAwareInterface
{
    use TranslatorAwareTrait;

    public function init() {
        $this->setName('cmsPages');

        $this->add([
            'name' => 'cmsPages',
            'type' => 'Zend\Form\Element\Collection',
            'options' => [
                'use_as_base_fieldset' => true,
                'label' => $this->translate('Cms Page'),
                'count' => 2,
                'should_create_template' => true,
                'allow_add' => true,
                'allow_remove' => true,
                'target_element' => ['type' => \Stagem\ZfcCmsPage\Form\Admin\CmsPageFieldset::class],
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'attributes' => [
                'type' => 'submit',
                'value' => $this->translate('Save'),
                'class' => 'btn btn-primary',
            ]
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