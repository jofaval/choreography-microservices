import { Kafka } from "kafkajs";
import {
  ShopOrderRequest,
  shopOrderRequestValidator,
} from "../validators/shop-order-request.validator";

// TODO: use dotenv
const KAFKA_GROUP_ID = "";
// TODO: use dotenv
const KAFKA_BROKERS = "";
// TODO: use dotenv
const NOTIFICATIONS_TOPIC = "";

const kafka = new Kafka({ brokers: [KAFKA_BROKERS] });
const consumer = kafka.consumer({ groupId: KAFKA_GROUP_ID });

function deserialize(raw: object) {
  return shopOrderRequestValidator.safeParse(raw);
}

function decode(message: string) {
  return deserialize(JSON.parse(message));
}

export async function read(onMessage: (payload: ShopOrderRequest) => void) {
  await consumer.connect();
  await consumer.subscribe({ topic: NOTIFICATIONS_TOPIC });
  await consumer.run({
    eachMessage: async ({ message }) => {
      const messageValue = message.value.toString();

      const decodingResponse = decode(messageValue);
      if (!decodingResponse.success) {
        console.error("invalid message", messageValue);
        return;
      }

      console.log("message", decodingResponse.data);
      onMessage(decodingResponse.data);
    },
  });
}
