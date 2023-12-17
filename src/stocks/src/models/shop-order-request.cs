namespace Stocks
{
    class ShopOrderRequestData
    {
        public string uuid;
        public string customer;
        public string email;
        public string address;
        public string credit;
        public string product;
        public int quantity;
        public double price;
        public double paid;
        public string shipment;
        public string invoice;

        public ShopOrderRequestData(
            string uuid,
            string customer,
            string email,
            string address,
            string credit,
            string product,
            int quantity,
            double price,
            double paid,
            string shipment,
            string invoice
        )
        {
            this.uuid = uuid;
            this.customer = customer;
            this.email = email;
            this.address = address;
            this.credit = credit;
            this.product = product;
            this.quantity = quantity;
            this.price = price;
            this.paid = paid;
            this.shipment = shipment;
            this.invoice = invoice;
        }

        static ShopOrderRequestData parse(Dictionary raw)
        {
            return new ShopOrderRequestData(
                uuid: raw.get("uuid"),
                customer: raw.get("customer"),
                email: raw.get("email"),
                address: raw.get("address"),
                credit: raw.get("credit"),
                product: raw.get("product"),
                quantity: raw.get("quantity"),
                price: raw.get("price"),
                paid: raw.get("paid"),
                shipment: raw.get("shipment"),
                invoice: raw.get("invoice"),
            );
        }
    }

    class ShopOrderRequest
    {
        public string groupId;
        public bool success;
        public ShopOrderRequestData shopOrderRequestData;

        public ShopOrderRequest(string groupId, bool success, ShopOrderRequestData shopOrderRequestData)
        {
            this.groupId = groupId;
            this.success = success;
            this.shopOrderRequestData = shopOrderRequestData;
        }

        public ShopOrderRequest parse(Dictionary raw)
        {
            return new ShopOrderRequest(
                groupId: raw.get(groupId),
                success: raw.get(success),
                shopOrderRequestData: ShopOrderRequestData.parse(raw.get(shopOrderRequestData)),
            );
        }
    }
}
