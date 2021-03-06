<?php
/**
 * Automatically created by MageSpecialist CodeMonkey
 * https://github.com/magespecialist/m2-MSP_CodeMonkey
 */

declare(strict_types=1);

namespace MSP\Notifier\Model\Channel\Command;

use Magento\Framework\Exception\NoSuchEntityException;
use MSP\Notifier\Model\ResourceModel\Channel;
use MSP\NotifierApi\Api\Data\ChannelInterface;
use MSP\NotifierApi\Api\Data\ChannelInterfaceFactory;

/**
 * @inheritdoc
 */
class GetByCode implements GetByCodeInterface
{
    /**
     * @var Channel
     */
    private $resource;

    /**
     * @var ChannelInterfaceFactory
     */
    private $factory;

    /**
     * @param Channel $resource
     * @param ChannelInterfaceFactory $factory
     */
    public function __construct(
        Channel $resource,
        ChannelInterfaceFactory $factory
    ) {
        $this->resource = $resource;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $code): ChannelInterface
    {
        /** @var ChannelInterface $channel */
        $channel = $this->factory->create();
        $this->resource->load(
            $channel,
            $code,
            ChannelInterface::CODE
        );

        if (null === $channel->getId()) {
            throw new NoSuchEntityException(__('Channel with code "%value" does not exist.', [
                'value' => $code
            ]));
        }

        return $channel;
    }
}
