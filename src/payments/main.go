package main

import (
	"capgemini.com/payments/src"
)

// TODO: use dotenv
const (
	PAYMENTS_TOPIC = ""
	TEAM_ID        = 3
)

func main() {
	conn := src.Connect()

	src.Read(PAYMENTS_TOPIC, func(payload *src.ShopOrderRequest) {
		if payload.GroupId != "team-"+string(TEAM_ID) {
			return
		}

		src.Process(conn, payload)
	})
}
