<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Stagem Team
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Stagem
 * @package Stagem_Question
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Stagem\ZfcCmsPage\Block\Grid;

use Popov\ZfcDataGrid\Block\AbstractGrid;

class CmsPageGrid extends AbstractGrid
{
    public function init()
    {
        $grid = $this->getDataGrid();
        $grid->setId('cms_page');
        $grid->setTitle('Pages');

        $rendererOptions = $grid->getToolbarTemplateVariables();

        $rendererOptions['navGridDel'] = true;
        $rendererOptions['inlineNavCancel'] = true;
        $rendererOptions['navGridRefresh'] = true;

        $grid->setToolbarTemplateVariables($rendererOptions);

        $colId = $this->add([
            'name' => 'Select',
            'construct' => ['pageUrl', 'cms_page'],
            'identity' => true,
        ])->getDataGrid()->getColumnByUniqueId('cms_page_pageUrl');

        $this->add([
            'name' => 'Select',
            'construct' => ['pageUrl', 'cms_page'],
            'label' => 'Name',
            'identity' => false,
            'width' => 3,
        ]);

        $this->add([
            'name' => 'Action',
            'construct' => ['edit'],
            'label' => ' ',
            'width' => 1,
            'formatters' => [[
                'name' => 'Link',
                'attributes' => ['class' => 'pencil-edit-icon', 'target' => '_blank'],
                'link' => ['href' => '/admin/cms-page/edit', 'placeholder_column' => $colId]
            ]],
        ]);

        return $this;
    }
}