import json
from typing import Dict

from kafka import KafkaConsumer, KafkaProducer
from src.models.shopOrderRequest import ShopOrderRequest

# TODO: use dotenv configuration
KAFKA_BROKER = ""


class TopicHandler:
    consumers: Dict[str, KafkaConsumer]
    producer: KafkaProducer

    def deserialize(self, payload):
        return ShopOrderRequest.parse(json.loads(payload))

    def decode(self, message):
        return self.deserialize(str(message).decode(encoding="UTF-8"))

    def read(self, topic: str):
        if topic not in self.consumers:
            self.consumers[topic] = KafkaConsumer(
                topic,
                bootstrap_servers=KAFKA_BROKER
            )

        for message in self.consumers[topic]:
            yield self.decode(message)

    def serialize(self, payload: ShopOrderRequest):
        return str(payload)

    def encode(self, message):
        return self.serialize(message).encode(encoding="UTF-8")

    def send(self, topic, message):
        if not self.producer:
            self.producer = KafkaProducer(bootstrap_servers=KAFKA_BROKER)

        return self.producer.send(topic, value=self.encode(message)).get(10)
