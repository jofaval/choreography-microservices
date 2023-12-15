<?php

interface ServiceHandler
{
    public function success();
    public function fail();
    public function process();
}

class ShipmentsHandler implements ServiceHandler
{
    /** @var ShopOrderRequest */
    public $shop_order_request;

    public function success(): void
    {
        $this->shop_order_request->success = true;
        throw new Error("Not implemented");
        // TODO: topic handler -> invoices
    }

    private function rollback()
    {
        throw new Error("Not implemented");
    }

    public function fail(): void
    {
        $this->shop_order_request->success = false;
        try {
            $this->rollback();
        } finally {
            throw new Error("Not implemented");
            // TODO: handle error, retries?
            // TODO: topic handler -> payments
        }
    }

    private function ship(): bool
    {
        $success = false;
        $data = [
            "uuid" => $this->shop_order_request->shop_order_request_data->uuid,
            "customer" => $this->shop_order_request->shop_order_request_data->customer,
            "address" => $this->shop_order_request->shop_order_request_data->address,
            "shipment" => $this->shop_order_request->shop_order_request_data->shipment,
        ];
        throw new Error("Not implemented");

        return $success;
    }

    private function process_shipment()
    {
        $address = $this->shop_order_request->shop_order_request_data->address;
        if (!isset($address) || empty($address)) {
            return false;
        }

        $this->shop_order_request->shop_order_request_data->shipment = date("c");
        return $this->ship();
    }

    public function process(): void
    {
        if (!$this->shop_order_request->success) {
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
