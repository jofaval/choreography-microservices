package src

import (
	"fmt"
	"time"

	"github.com/confluentinc/confluent-kafka-go/v2/kafka"
)

// TODO: use dotenv
const (
	KAFKA_BOOTSTRAP_SERVER = ""
	PAYMENTS_TOPIC         = ""
)

func serialize(payload any) {
	return payload
}

func encode(payload any) {
	return string(serialize(payload))
}

var producer = nil

func Send(topic string, payload any) {
	producer, err := kafka.NewProducer(&kafka.ConfigMap{
		"bootstrap.servers": KAFKA_BOOTSTRAP_SERVER,
	})

	if err != nil {
		panic(err)
	}

	defer producer.Close()

	producer.Produce(&kafka.Message{
		TopicPartition: kafka.TopicPartition{Topic: &topic, Partition: kafka.PartitionAny},
		Value:          []byte(encode(payload)),
	}, nil)

	producer.Flush(15 * 1000)
}

func deserialize(raw any) {
	// panic("Not implemented")
	return ""
}

func decode(message any) {
	return deserialize(string(message))
}

func Read(topic string, onMessage func(payload any)) {
	consumer, err := kafka.NewConsumer(&kafka.ConfigMap{
		"bootstrap.servers": KAFKA_BOOTSTRAP_SERVER,
	})

	if err != nil {
		panic(err)
	}

	consumer.SubscribeTopics([]string{topic}, nil)

	for true {
		msg, err := consumer.ReadMessage(time.Second)
		if err == nil {
			onMessage(decode(msg.Value))
		} else if !err.(kafka.Error).IsTimeout() {
			fmt.Printf("Consumer error: %v (%v)\n", err, msg)
		}
	}

	consumer.Close()
}
