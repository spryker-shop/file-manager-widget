<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\FileManagerWidget\Dependency\Client;

use Generated\Shared\Transfer\FileStorageDataTransfer;

interface FileManagerWidgetToFileManagerStorageClientInterface
{
    public function findFileById(int $idFile, string $localeName): ?FileStorageDataTransfer;

    public function findFileByUuid(string $uuid, string $localeName): ?FileStorageDataTransfer;
}
