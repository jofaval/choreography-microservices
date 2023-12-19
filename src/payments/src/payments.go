package src

import "database/sql"

// TODO: use dotenv
const (
	STOCKS_TOPIC    = "stock"
	SHIPMENTS_TOPIC = "shipment"
	PAYMENTS_TABLE  = "payments"
)

type PaymentEntry struct {
	uuid     string
	customer string
	credit   string
	paid     float64
}

func success(conn *sql.DB, shopOrderRequest *ShopOrderRequest) {
	shopOrderRequest.Success = true
	Send(SHIPMENTS_TOPIC, shopOrderRequest)
}

func compensate(conn *sql.DB, shopOrderRequest *ShopOrderRequest) {
	panic("Not implemented")
	del(conn)
}

func fail(conn *sql.DB, shopOrderRequest *ShopOrderRequest) {
	shopOrderRequest.Success = false
	compensate(conn, shopOrderRequest)
	Send(STOCKS_TOPIC, shopOrderRequest)
}

func pay(conn *sql.DB, shopOrderRequest *ShopOrderRequest) {
	insert(conn, PAYMENTS_TABLE, PaymentEntry{
		uuid:     shopOrderRequest.ShopOrderRequestData.Uuid,
		customer: shopOrderRequest.ShopOrderRequestData.Customer,
		credit:   shopOrderRequest.ShopOrderRequestData.Credit,
		paid:     shopOrderRequest.ShopOrderRequestData.Paid,
	})
}

func processPayment(conn *sql.DB, shopOrderRequest *ShopOrderRequest) bool {
	if shopOrderRequest.ShopOrderRequestData.Credit == "" {
		return false
	}

	shopOrderRequest.ShopOrderRequestData.Paid = shopOrderRequest.ShopOrderRequestData.Price * float64(shopOrderRequest.ShopOrderRequestData.Quantity)

	return true
}

func Process(conn *sql.DB, shopOrderRequest *ShopOrderRequest) {
	if !shopOrderRequest.Success {
		fail(conn, shopOrderRequest)
		return
	}

	if processPayment(conn, shopOrderRequest) {
		success(conn, shopOrderRequest)
		return
	}

	fail(conn, shopOrderRequest)
}
