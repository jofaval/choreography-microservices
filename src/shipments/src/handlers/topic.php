<?php

// TODO: use dotenv
define("KAFKA_BROKER_SERVER", "");
define("KAFKA_CONSUME_TIMEOUT", 1_000);

class TopicHandler
{
    /** @var RdKafka\Consumer */
    private $consumer;
    /** @var RdKafka\Producer */
    private $producer;
    /** @var array{id:string,name:RdKafka\Topic[]} */
    private $topics;

    public function __construct()
    {
        $conf = new RdKafka\Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->set('debug', 'all');

        $this->consumer = new RdKafka\Producer($conf);
        $this->consumer->addBrokers(KAFKA_BROKER_SERVER);

        $this->producer = new RdKafka\Consumer($conf);
        $this->consumer->addBrokers(KAFKA_BROKER_SERVER);

        $this->topics = [];
    }

    function deserialize(array $raw): ShopOrderRequest
    {
        return ShopOrderRequest::parse($raw);
    }

    function decode(string $message)
    {
        return $this->deserialize(json_decode($message));
    }

    private function handle_consumption_error($message)
    {
        echo $message->errstr(), "\n";
    }

    function read(string $topic_id, callable $on_msg)
    {
        $topic = $this->consumer->newTopic($topic_id);
        $topic->consumeStart(0, 0);

        while (true) {
            $msg = $topic->consume(0, KAFKA_CONSUME_TIMEOUT);

            if (null === $msg || $msg->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
                continue;
            } elseif ($msg->err) {
                $this->handle_consumption_error($msg);
                break;
            } else {
                $on_msg($this->decode($msg->payload));
            }
        }
    }

    function serialize(ShopOrderRequest $payload): string
    {
        return json_encode($payload->serialize());
    }

    function encode(ShopOrderRequest $payload)
    {
        return (string) $this->serialize($payload);
    }

    function get_topic(string $topic_id)
    {
        if (!isset($this->topics[$topic_id])) {
            $this->topics[$topic_id] = $this->producer->newTopic($topic_id);
        }

        return $this->topics[$topic_id];
    }

    function send(string $topic_id, ShopOrderRequest $payload)
    {
        $topic = $this->get_topic($topic_id);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $this->encode($payload));
    }
}
