<?php
declare(strict_types=1);

namespace CBH\UiscomClient\CallApi\Endpoints\CallCreation;

use CBH\UiscomClient\Constants;
use CBH\UiscomClient\Contracts\EndpointInterface;

/**
 * Class StartSimpleCall
 * https://comagic.github.io/call-api/#start.simple_call
 */
class StartSimpleCall implements EndpointInterface
{
    /**
     * @var string - кому первому звоним (operator или contact)
     */
    private $firstCall;

    /**
     * @return string
     */
    public function getEndpointName(): string
    {
        return Constants::CALL_API_METHOD_START_SIMPLE_CALL;
    }

    /**
     * @return array
     */
    public function make(): array
    {
        return [

        ];
    }

    /**
     * Звонок сначала оператору - затем посетителю
     *
     * @return StartSimpleCall
     */
    public function setOperatorFirst(): StartSimpleCall
    {
        $this->firstCall = Constants::CLIENT_OPERATOR;

        return $this;
    }

    /**
     * Звонок сначала посетителю - затем оператору
     *
     * @return StartSimpleCall
     */
    public function setContactFirst(): StartSimpleCall
    {
        $this->firstCall = Constants::SITE_VISITOR;

        return $this;
    }
}