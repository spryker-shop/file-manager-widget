<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\FileManagerWidget;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\FileManagerWidget\Dependency\Client\FileManagerWidgetToFileManagerStorageClientInterface;
use SprykerShop\Yves\FileManagerWidget\Dependency\Service\FileManagerWidgetToFileManagerServiceInterface;

class FileManagerWidgetFactory extends AbstractFactory
{
    public function getFileManagerService(): FileManagerWidgetToFileManagerServiceInterface
    {
        return $this->getProvidedDependency(FileManagerWidgetDependencyProvider::SERVICE_FILE_MANAGER);
    }

    public function getFileManagerStorageClient(): FileManagerWidgetToFileManagerStorageClientInterface
    {
        return $this->getProvidedDependency(FileManagerWidgetDependencyProvider::CLIENT_FILE_MANAGER_STORAGE);
    }
}
