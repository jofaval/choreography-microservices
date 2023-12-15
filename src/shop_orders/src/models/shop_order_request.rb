class ShopOrderRequestData
    @uuid
    @customer
    @email
    @address
    @credit
    @product
    @quantity
    @price
    @paid
    @shipment
    @invoice
end

class ShopOrderRequest
    @groupId
    @success
    @shopOrderRequestData
end
