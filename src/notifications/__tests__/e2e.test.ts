// mocks
import invoice_failure from "./__mocks__/notification_invoice_failure.json";
import payment_failure from "./__mocks__/notification_payment_failure.json";
import shipment_failure from "./__mocks__/notification_shipment_failure.json";
import stock_failure from "./__mocks__/notification_stock_failure.json";
import success from "./__mocks__/notification_success.json";

// TODO: automate mocks, the group id?

const NOTIFICATION_TOPIC = "notifications";

function send(rawMessage: object) {
  const message = JSON.stringify(rawMessage);
  NOTIFICATION_TOPIC;
  throw new Error("not implemented");
}

async function fire(...payloads) {
  await Promise.all(payloads.map((payload) => () => send(payload)));
}

function test() {
  fire(
    invoice_failure,
    payment_failure,
    shipment_failure,
    stock_failure,
    success
  );
}

test();
