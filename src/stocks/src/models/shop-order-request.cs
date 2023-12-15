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
    }

    class ShopOrderRequest
    {
        public string groupId;
        public bool success;
        public ShopOrderRequestData shopOrderRequestData;
    }
}