package src

// TODO: use dotenv
const (
	STOCKS_TOPIC    = "stock"
	SHIPMENTS_TOPIC = "shipment"
)

type PaymentEntry struct {
	uuid     string
	customer string
	credit   string
	paid     float64
}

func success(shopOrderRequest *ShopOrderRequest) {
	shopOrderRequest.shopOrderRequestData.success = true
	Send(SHIPMENTS_TOPIC, shopOrderRequest)
}

func fail(shopOrderRequest *ShopOrderRequest) {
	shopOrderRequest.shopOrderRequestData.success = false
	Send(STOCKS_TOPIC, shopOrderRequest)
}

func pay(shopOrderRequest *ShopOrderRequest) {
	data := PaymentEntry{
		uuid:     shopOrderRequest.shopOrderRequestData.uuid,
		customer: shopOrderRequest.shopOrderRequestData.customer,
		credit:   shopOrderRequest.shopOrderRequestData.credit,
		paid:     shopOrderRequest.shopOrderRequestData.paid,
	}
	panic("Not implemented")
}

func processPayment(shopOrderRequest *ShopOrderRequest) bool {
	if shopOrderRequest.shopOrderRequestData.credit == "" {
		return false
	}

	shopOrderRequest.shopOrderRequestData.paid = shopOrderRequest.shopOrderRequestData.price * float64(shopOrderRequest.shopOrderRequestData.quantity)

	return true
}

func Process(shopOrderRequest *ShopOrderRequest) {
	if !shopOrderRequest.success {
		fail(shopOrderRequest)
		return
	}

	if processPayment(shopOrderRequest) {
		success(shopOrderRequest)
		return
	}

	fail(shopOrderRequest)
}
