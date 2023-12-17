import { ShopOrderRequest } from "../validators/shop-order-request.validator";

interface ServiceHandler {
  shopOrderRequest: ShopOrderRequest;
  success: () => void;
  fail: () => void;
  process: () => void;
}

const isValueEmpty = (value: unknown) => {
  return value === undefined || value === null;
};

export class NotificationsHandler implements ServiceHandler {
  shopOrderRequest: ShopOrderRequest;

  constructor(shopOrderRequest: ShopOrderRequest) {
    this.shopOrderRequest = shopOrderRequest;
  }

  success() {
    console.log("Successful order", JSON.stringify(this.shopOrderRequest));
  }

  getFailureReason() {
    const requestData = this.shopOrderRequest.shopOrderRequestData;

    if (isValueEmpty(requestData.paid)) {
      return "payment" as const;
    } else if (isValueEmpty(requestData.shipment)) {
      return "shipment" as const;
    } else if (isValueEmpty(requestData.invoice)) {
      return "invoice" as const;
    }

    return "stock" as const;
  }

  fail() {
    console.log({
      uuid: this.shopOrderRequest.shopOrderRequestData.uuid,
      reason: this.getFailureReason(),
      details: JSON.stringify(this.shopOrderRequest),
    });
  }

  process() {
    if (this.shopOrderRequest.success) {
      this.success();
    } else {
      this.fail();
    }
  }
}
