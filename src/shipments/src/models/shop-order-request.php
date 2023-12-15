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
}

class ShopOrderRequest
{
    /** @var string */
    public $groupId;

    /** @var bool */
    public $success;

    /** @var ShopOrderRequestData */
    public $shopOrderRequestData;
}
