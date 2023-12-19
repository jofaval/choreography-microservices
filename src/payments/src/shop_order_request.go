package src

type shopOrderRequestData struct {
	Uuid     string
	Customer string
	Email    string
	Address  string
	Credit   string
	Product  string
	Quantity int
	Price    float64
	Paid     float64
	Shipment string
	Invoice  string
}

type ShopOrderRequest struct {
	GroupId              string
	Success              bool
	ShopOrderRequestData shopOrderRequestData
}
