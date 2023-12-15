import { ShopOrderRequest } from "../validators/shop-order-request.validator";

interface ServiceHandler {
  shopOrderRequest: ShopOrderRequest;
  success: () => void;
  fail: () => void;
}

export class NotificationsHandler implements ServiceHandler {
  shopOrderRequest: ShopOrderRequest;

  constructor() {}

  success() {}

  fail() {}
}
