interface IServiceHandler
{
    public ShopOrderRequest shopOrderRequest;
    public void success();
    public void fail();
}

class StocksHandler : IServiceHandler
{
    public ShopOrderRequest shopOrderRequest;

    public void success()
    {

    }

    public void fail()
    {

    }


}