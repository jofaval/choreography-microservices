<?php

// TODO: use dotenv
define("SHIPMENTS_TOPIC", "");
// TODO: use dotenv
define("TEAM_ID", "");

$topic_handler = new TopicHandler();
$topic_handler->read(SHIPMENTS_TOPIC, function (ShopOrderRequest $shop_order_request) {
    if ($shop_order_request->groupId != "team-{" . TEAM_ID . "}") {
        return;
    }

    (new ShipmentsHandler($shop_order_request, $topic_handler))->process();
});
