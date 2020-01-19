<?php
/**
 * WebTechnologyCodes
 *
 * Do not edit or add to this file if you wish to upgrade to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please contact us https://magentoextensions.in
 *
 * @category   WebTechnologyCodes
 * @package    WebTechnologyCodes_AdminActivity
 * @copyright  Copyright (C) 2018 WebTechnologyCodes LLP (https://magentoextensions.in)
 * @license    https://magentoextensions.in
 */

namespace WebTechnologyCodes\AdminActivity\Block\Adminhtml\System\Config\Fieldset;

use \Magento\Backend\Block\Template;
use \Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

/**
 * Class Hint
 * @package WebTechnologyCodes\AdminActivity\Block\Adminhtml\System\Config\Fieldset
 */
class Hint extends Template implements RendererInterface
{
    /**
     * @var \Magento\Framework\Module\ModuleList
     */
    private $moduleList;

    /**
     * Class constructor.
     * @param Template\Context $context
     * @param \Magento\Framework\Module\ModuleList $moduleList
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Module\ModuleList $moduleList,
        array $data = []
    ) {
        $this->_template = 'WebTechnologyCodes_AdminActivity::system/config/fieldset/hint.phtml';
        parent::__construct($context, $data);
        $this->moduleList = $moduleList;
    }

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $_element = $element;
        return $this->toHtml();
    }

    /**
     * @return mixed
     */
    public function getModuleVersion()
    {
        return $this->moduleList->getOne('WebTechnologyCodes_AdminActivity')['setup_version'];
    }
}
