using Confluent.Kafka;
using System.Net;
using System.Text.Json;
using System.Collections.Generic;

namespace Stocks
{
    // TODO: use dotenv
    const KAFKA_BOOTSTRAP_SERVER = "";

    class TopicHandler
    {
        private Producer producer;
        private Consumer consumer;

        public TopicHandler()
        {
            this.producer = new ProducerBuilder<Null, string>(new ProducerConfig
            {
                BootstrapServers = KAFKA_BOOTSTRAP_SERVER,
            }).Build();

            this.consumer = new ConsumerBuilder<Ignore, string>(new ConsumerConfig
            {
                BootstrapServers = KAFKA_BOOTSTRAP_SERVER,
            }).Build();
        }

        private void deserialize(Dictionary<string, string> raw)
        {
            // TODO: refactor parse into deserialize
            return ShopOrderRequest.parse(raw);
        }

        private void decode()
        {
            return deserialize(JsonSerializer.Deserialize<Dictionary<string, string>>(raw))
        }

        public void read(string topic, Func<ShopOrderRequest> onMessage)
        {
            consumer.Subscribe(topic);

            while (!cancelled)
            {
                var consumeResult = consumer.Consume(cancellationToken);
                onMessage(decode((string)consumeResult.value));
            }

            consumer.Close();
        }

        private void serialize(ShopOrderRequest shopOrderRequest)
        {
            return shopOrderRequest.serialize();
        }

        private void encode(ShopOrderRequest shopOrderRequest)
        {
            return (string)serialize(shopOrderRequest);
        }

        public void send(string topic, ShopOrderRequest shopOrderRequest)
        {
            var result = await producer.ProduceAsync(topic, new Message<Null, string> { Value = encode(shopOrderRequest) });
        }
    }
}