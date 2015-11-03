<?php

namespace Pyz\Zed\MailQueue\Business;

use Generated\Zed\Ide\FactoryAutoCompletion\MailQueueBusiness;
use Pyz\Zed\MailQueue\Business\Model\MailQueueManagerInterface;
use Pyz\Zed\MailQueue\MailQueueDependencyProvider;
use Pyz\Zed\Queue\Business\QueueFacade;
use SprykerEngine\Zed\Kernel\Business\AbstractBusinessDependencyContainer;
use SprykerFeature\Zed\Mail\Business\MailFacade;

/**
 * @method MailQueueBusiness getFactory()
 */
class MailQueueDependencyContainer extends AbstractBusinessDependencyContainer
{

    /**
     * @return MailQueueManagerInterface
     */
    public function createMailQueueManager()
    {
        return $this->getFactory()->createModelMailQueueManager(
            $this->createMailQueueFacade()
        );
    }

    /**
     * @throws \ErrorException
     *
     * @return MailFacade
     */
    public function createMailFacade()
    {
        return $this->getProvidedDependency(MailQueueDependencyProvider::MAIL_FACADE);
    }

    /**
     * @throws \ErrorException
     *
     * @return QueueFacade
     */
    public function createQueueFacade()
    {
        return $this->getProvidedDependency(MailQueueDependencyProvider::QUEUE_FACADE);
    }

    /**
     * @throws \ErrorException
     *
     * @return MailQueueFacade
     */
    public function createMailQueueFacade()
    {
        return $this->getProvidedDependency(MailQueueDependencyProvider::MAIL_QUEUE_FACADE);
    }

}
