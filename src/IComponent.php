<?php

/**
 * Aphiria
 *
 * @link      https://www.aphiria.com
 * @copyright Copyright (C) 2023 David Young
 * @license   https://github.com/aphiria/aphiria/blob/1.x/LICENSE.md
 */

declare(strict_types=1);

namespace Aphiria\Application;

/**
 * Defines the interface for application components to implement
 */
interface IComponent
{
    /**
     * Actually builds the component
     *
     * @note This will occur once services are resolvable
     */
    public function build(): void;
}
