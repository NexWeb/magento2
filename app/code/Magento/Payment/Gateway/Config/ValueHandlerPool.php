<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Payment\Gateway\Config;

use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;

class ValueHandlerPool implements \Magento\Payment\Gateway\Config\ValueHandlerPoolInterface
{
    /**
     * Default handler code
     */
    const DEFAULT_HANDLER = 'default';

    /**
     * @var ValueHandlerInterface[] | TMap
     */
    private $handlers;

    /**
     * @param TMapFactory $tmapFactory
     * @param array $handlers
     */
    public function __construct(
        TMapFactory $tmapFactory,
        array $handlers
    ) {
        if (!isset($handlers[self::DEFAULT_HANDLER])) {
            throw new \LogicException('Default handler should be provided.');
        }

        $this->handlers = $tmapFactory->create(
            [
                'array' => $handlers,
                'type' => ValueHandlerInterface::class
            ]
        );
    }

    /**
     * Retrieves an appropriate configuration value handler
     *
     * @param string $field
     * @return ValueHandlerInterface
     */
    public function get($field)
    {
        return isset ($this->handlers[$field])
            ? $this->handlers[$field]
            : $this->handlers[self::DEFAULT_HANDLER];
    }
}
