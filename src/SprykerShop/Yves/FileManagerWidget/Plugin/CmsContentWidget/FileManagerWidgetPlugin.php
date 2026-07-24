<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\FileManagerWidget\Plugin\CmsContentWidget;

use Spryker\Shared\CmsContentWidget\Dependency\CmsContentWidgetConfigurationProviderInterface;
use Spryker\Yves\CmsContentWidget\Dependency\CmsContentWidgetPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\FileManagerWidget\Dependency\Client\FileManagerWidgetToFileManagerStorageClientInterface;
use Twig\Environment;

/**
 * @method \SprykerShop\Yves\FileManagerWidget\FileManagerWidgetFactory getFactory()
 */
class FileManagerWidgetPlugin extends AbstractPlugin implements CmsContentWidgetPluginInterface
{
    /**
     * @var string
     */
    protected const MESSAGE_FILE_IS_MISSING = 'File with id %s does not exist';

    /**
     * @var \Spryker\Shared\CmsContentWidget\Dependency\CmsContentWidgetConfigurationProviderInterface
     */
    protected $widgetConfiguration;

    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function __construct(CmsContentWidgetConfigurationProviderInterface $widgetConfiguration)
    {
        $this->widgetConfiguration = $widgetConfiguration;
    }

    /**
     * {@inheritDoc}
     *
     * @return callable
     */
    public function getContentWidgetFunction()
    {
        return [$this, 'contentWidgetFunction'];
    }

    /**
     * {@inheritDoc}
     *
     * @param array|string|int $idFiles
     */
    public function contentWidgetFunction(Environment $twig, array $context, $idFiles, ?string $templateIdentifier = null): string
    {
        return $twig->render(
            $this->resolveTemplatePath($templateIdentifier),
            $this->getContent($context, $idFiles),
        );
    }

    protected function resolveTemplatePath(?string $templateIdentifier = null): string
    {
        if (!$templateIdentifier) {
            $templateIdentifier = CmsContentWidgetConfigurationProviderInterface::DEFAULT_TEMPLATE_IDENTIFIER;
        }

        return $this->widgetConfiguration->getAvailableTemplates()[$templateIdentifier];
    }

    /**
     * @param array $context
     * @param array|string|int $idFiles
     *
     * @return array
     */
    protected function getContent(array $context, $idFiles): array
    {
        $files = [];

        if (!is_array($idFiles)) {
            $idFiles = [$idFiles];
        }

        foreach ($idFiles as $idFile) {
            $files[] = $this->getFileManagerStorageClient()->findFileById((int)$idFile, $this->getLocale()) ?: $this->createMissingFileMessage($idFile);
        }

        return ['files' => $files];
    }

    protected function getFileManagerStorageClient(): FileManagerWidgetToFileManagerStorageClientInterface
    {
        return $this->getFactory()->getFileManagerStorageClient();
    }

    /**
     * @param string|int $idFile
     *
     * @return string
     */
    protected function createMissingFileMessage($idFile): string
    {
        return sprintf(static::MESSAGE_FILE_IS_MISSING, $idFile);
    }
}
