package main

// TODO: use dotenv
const (
	PAYMENTS_TOPIC = ""
	TEAM_ID        = 3
)

func main() {
	Read(PAYMENTS_TOPIC, func(payload ShopOrderRequest) {
		if payload.groupId != "team-"+string(TEAM_ID) {
			return
		}

		Process(payload)
	})
}
