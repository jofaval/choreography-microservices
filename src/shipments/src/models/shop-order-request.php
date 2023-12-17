<?php

class ShopOrderRequestData
{
    /** @var string */
    public $uuid;

    /** @var string */
    public $customer;

    /** @var string */
    public $email;

    /** @var string */
    public $address;

    /** @var string */
    public $credit;

    /** @var string */
    public $product;

    /** @var int */
    public $quantity;

    /** @var float */
    public $price;

    /** @var float */
    public $paid;

    /** @var string */
    public $shipment;

    /** @var string */
    public $invoice;

    public function __construct(
        string $uuid,
        string $customer,
        string $email,
        string $address,
        string $credit,
        string $product,
        int $quantity,
        float $price,
        float $paid,
        string $shipment,
        string $invoice
    ) {
        $this->uuid = $uuid;
        $this->customer = $customer;
        $this->email = $email;
        $this->address = $address;
        $this->credit = $credit;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->paid = $paid;
        $this->shipment = $shipment;
        $this->invoice = $invoice;
    }

    static function parse(array $raw): ShopOrderRequestData
    {
        return new ShopOrderRequestData(
            $raw["uuid"],
            $raw["customer"],
            $raw["email"],
            $raw["address"],
            $raw["credit"],
            $raw["product"],
            $raw["quantity"],
            $raw["price"],
            $raw["paid"],
            $raw["shipment"],
            $raw["invoice"],
        );
    }

    public function serialize()
    {
        return [
            "uuid" => $this->uuid,
            "customer" => $this->customer,
            "email" => $this->email,
            "address" => $this->address,
            "credit" => $this->credit,
            "product" => $this->product,
            "quantity" => $this->quantity,
            "price" => $this->price,
            "paid" => $this->paid,
            "shipment" => $this->shipment,
            "invoice" => $this->invoice,
        ];
    }
}

class ShopOrderRequest
{
    /** @var string */
    public $groupId;

    /** @var bool */
    public $success;

    /** @var ShopOrderRequestData */
    public $shopOrderRequestData;

    public function __construct(string $groupId, bool    $success, ShopOrderRequestData $shopOrderRequestData)
    {
        $this->groupId = $groupId;
        $this->success = $success;
        $this->shopOrderRequestData = $shopOrderRequestData;
    }

    static function parse(array $raw): ShopOrderRequest
    {
        return new ShopOrderRequest(
            $raw["groupId"],
            $raw["success"],
            ShopOrderRequestData::parse($raw["shopOrderRequestData"])
        );
    }

    public function serialize()
    {
        return [
            "groupId" => $this->groupId,
            "success" => $this->success,
            "shopOrderRequestData" => $this->shopOrderRequestData->serialize(),
        ];
    }
}
