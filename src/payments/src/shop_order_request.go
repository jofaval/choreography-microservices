package src

type shopOrderRequestData struct {
	uuid     string
	customer string
	email    string
	address  string
	credit   string
	product  string
	quantity int
	price    float64
	paid     float64
	shipment string
	invoice  string
}

type ShopOrderRequest struct {
	groupId              string
	success              bool
	shopOrderRequestData shopOrderRequestData
}
