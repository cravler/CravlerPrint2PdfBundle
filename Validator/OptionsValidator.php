<?php

namespace Cravler\Print2PdfBundle\Validator;

use Symfony\Component\Config\Definition\Processor;
use Cravler\Print2PdfBundle\DependencyInjection\Configuration;

/**
 * @author Sergei Vizel <sergei.vizel@gmail.com>
 */
class OptionsValidator
{
    /**
     * @param array $options
     */
    public static function validate(array $options = array())
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $node = $configuration->getOptionsNode('options')->getNode(true);
        $processor->process($node, array('options' => $options));
    }
}
