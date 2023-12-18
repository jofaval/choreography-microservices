<?php

// TODO: require vendor

/**
 * joins paths
 */
function j()
{
    return implode(DIRECTORY_SEPARATOR, func_get_args());
}

define("SRC_PATH", j(__DIR__, "src"));

define("MODELS_PATH", j(SRC_PATH, "models"));
require_once j(MODELS_PATH, "shop_order_request.php");

define("HANDLERS_PATH", j(SRC_PATH, "handlers"));
require_once j(HANDLERS_PATH, "topic.php");
require_once j(HANDLERS_PATH, "shipments.php");
