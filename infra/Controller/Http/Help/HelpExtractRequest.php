<?php

declare(strict_types=1);

namespace App\Infra\Controller\Http\Help;

use App\Infra\Controller\ResourceNotFound;

trait HelpExtractRequest
{
    /**
     * @throws ResourceNotFound
     */
    private function getId(): string
    {
        $matches = [];
        preg_match('/\/([a-z\-0-9]+)\/$/', $this->request->getUri()->getPath(), $matches);

        if (! isset($matches[1])) {
            throw new ResourceNotFound('id-not-found');
        }

        return $matches[1];
    }
}
