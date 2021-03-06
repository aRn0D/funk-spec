<?php

namespace Funk\Output\Formatter\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Behat\Testwork\Exception\ServiceContainer\ExceptionExtension;
use Symfony\Component\DependencyInjection\Reference;
use Behat\Testwork\Output\ServiceContainer\OutputExtension;
use Behat\Testwork\Output\ServiceContainer\Formatter\FormatterFactory;

class Pretty implements FormatterFactory
{
    public function buildFormatter(ContainerBuilder $container)
    {
        $definition = new Definition('Funk\Output\Formatter\Pretty', array(
            $this->createOutputPrinterDefinition(),
            new Reference(ExceptionExtension::PRESENTER_ID),
            '%paths.base%'
        ));
        $definition->addTag(OutputExtension::FORMATTER_TAG, array('priority' => 100));
        $container->setDefinition(OutputExtension::FORMATTER_TAG . '.pretty', $definition);
    }

    public function processFormatter(ContainerBuilder $container)
    {
    }

    protected function createOutputPrinterDefinition()
    {
        $definition = new Definition('Behat\Testwork\Output\Printer\StreamOutputPrinter', [
            new Definition('Behat\Testwork\Output\Printer\Factory\ConsoleOutputFactory'),
        ]);
        $definition->addMethodCall('setOutputStyles', [
            [
                'failed'  => ['red'],
                'passed'  => ['green'],
                'spec'    => ['yellow'],
                'comment' => ['cyan'],
                'lineno'  => ['yellow'],
                'diff-add'  => ['green'],
                'diff-del'  => ['red'],
                'code'  => ['cyan'],
                'trace'  => ['white'],
                'trace-class'  => ['magenta'],
                'trace-func'  => ['green'],
                'trace-type'  => ['cyan'],
                'trace-value'  => ['red'],
                'trace-args'  => ['yellow'],
                'hl'  => ['red'],
                'value' => ['red']
                //black, red, green, yellow, blue, magenta, cyan, white
            ]
        ]);


        return $definition;
    }
}
