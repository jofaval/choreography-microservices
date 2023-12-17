namespace Stocks
{
    const PAYMENTS_TOPIC = "";
    const SHOP_ORDERS_TOPIC = "";

    interface IServiceHandler
    {
        public ShopOrderRequest shopOrderRequest;
        public void success();
        public void fail();
        public void process();
    }

    class StocksHandler : IServiceHandler
    {
        public ShopOrderRequest shopOrderRequest;
        private TopicHandler topicHandler;

        public StocksHandler(ShopOrderRequest shopOrderRequest, TopicHandler topicHandler)
        {
            this.shopOrderRequest = shopOrderRequest;
            this.topicHandler = topicHandler;
        }

        public void success()
        {
            shopOrderRequest.shopOrderRequestData.success = true;
            topicHandler.send(PAYMENTS_TOPIC, shopOrderRequest);
        }

        private void compensate()
        {
            throw new Exception("Not implemented");
        }

        public void fail()
        {
            shopOrderRequest.shopOrderRequestData.success = false;

            try
            {
                compensate();
            }
            finally
            {
                // TODO: handle error, retries?
                topicHandler.send(SHOP_ORDERS_TOPIC, shopOrderRequest);
            }
        }

        private bool productExists(StockProduct product)
        {
            return product != null;
        }

        private bool productHasEnoughStock(StockProduct product)
        {
            return product.stock >= shopOrderRequest.shopOrderRequestData.quantity > 0;
        }

        private bool isValidProductOrder(StockProduct product)
        {
            return productExists(product) && productHasEnoughStock(product)
        }

        private StockProduct getProduct()
        {
            throw new Exception("Not implemented");
        }

        private bool decrementStock(StockProduct product)
        {
            throw new Exception("Not implemented");
            return true;
        }

        private bool processStock()
        {
            StockProduct product = getProduct()

            if (!isValidProductOrder(product))
            {
                return false;
            }

            shopOrderRequest.shopOrderRequestData.price = product.price;
            return decrementStock(product);
        }

        public void process()
        {
            if (!shopOrderRequest.success)
            {
                return fail();
            }

            if (processStock())
            {
                return success();
            }

            fail();
        }
    }
}