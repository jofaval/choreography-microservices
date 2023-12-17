<?php

// TODO: use dotenv
define("INVOICES_TOPIC", "");
// TODO: use dotenv
define("PAYMENTS_TOPIC", "");

interface ServiceHandler
{
    public function success();
    public function fail();
    public function process();
}

class ShipmentsHandler implements ServiceHandler
{
    /** @var ShopOrderRequest */
    public $shopOrderRequest;

    /** @var TopicHandler */
    public $topic_handler;

    public function __construct(
        ShopOrderRequest $shopOrderRequest,
        TopicHandler $topic_handler
    ) {
        $this->shopOrderRequest = $shopOrderRequest;
        $this->topic_handler = $topic_handler;
    }

    public function success(): void
    {
        $this->shopOrderRequest->success = true;
        $this->topic_handler->send(INVOICES_TOPIC, $this->shopOrderRequest);
    }

    private function compensate()
    {
        throw new Error("Not implemented");
    }

    public function fail(): void
    {
        $this->shopOrderRequest->success = false;
        try {
            $this->compensate();
        } finally {
            // TODO: handle error, retries?
            $this->topic_handler->send(PAYMENTS_TOPIC, $this->shopOrderRequest);
        }
    }

    private function ship(): bool
    {
        $success = false;
        $data = [
            "uuid" => $this->shopOrderRequest->shopOrderRequestData->uuid,
            "customer" => $this->shopOrderRequest->shopOrderRequestData->customer,
            "address" => $this->shopOrderRequest->shopOrderRequestData->address,
            "shipment" => $this->shopOrderRequest->shopOrderRequestData->shipment,
        ];
        throw new Error("Not implemented");

        return $success;
    }

    private function process_shipment()
    {
        $address = $this->shopOrderRequest->shopOrderRequestData->address;
        if (!isset($address) || empty($address)) {
            return false;
        }

        $this->shopOrderRequest->shopOrderRequestData->shipment = date("c");
        return $this->ship();
    }

    public function process(): void
    {
        if (!$this->shopOrderRequest->success) {
            $this->fail();
            return;
        }

        if ($this->process_shipment()) {
            $this->success();
        } else {
            $this->fail();
        }
    }
}
