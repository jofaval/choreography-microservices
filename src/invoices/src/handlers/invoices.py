from pydantic import BaseModel
from src.handlers.topic import TopicHandler
from src.models.shopOrderRequest import ShopOrderRequest

MAX_INVOICE_LEN = 60

# TODO: use dotenv
TEAM_ID = 3
# TODO: use dotenv
SHOP_ORDERS_TOPIC = ""
# TODO: use dotenv
STOCKS_TOPIC = ""
# TODO: use dotenv
PAYMENTS_TOPIC = ""
# TODO: use dotenv
SHIPMENTS_TOPIC = ""
# TODO: use dotenv
INVOICES_TOPIC = ""
# TODO: use dotenv
NOTIFICATIONS_TOPIC = ""


class InvoicesHandler(BaseModel):
    """Invoices microservice handler"""
    shopOrderRequest: ShopOrderRequest
    topic_handler: TopicHandler

    def success(self):
        """Success path"""
        self.shopOrderRequest.success = True
        self.topic_handler.send(SHOP_ORDERS_TOPIC, self.shopOrderRequest)

    def fail(self):
        """Failure path"""
        self.shopOrderRequest.success = False
        self.topic_handler.send(SHIPMENTS_TOPIC, self.shopOrderRequest)

    def generate_invoice(self):
        """UUID + Customer + Product"""
        data = self.shopOrderRequest.shopOrderRequestData
        invoice: str = data.uuid + data.customer + data.product

        self.shopOrderRequest.shopOrderRequestData.invoice = invoice

    def is_valid_invoice(self):
        """Should not surpass the max amount"""
        return len(self.shopOrderRequest.shopOrderRequestData.invoice) <= MAX_INVOICE_LEN

    def process_invoice(self):
        """Actual invoice processing"""
        self.generate_invoice()
        return self.is_valid_invoice()

    def process(self):
        """Orchestrator"""
        if self.shopOrderRequest.groupId != f"team-{TEAM_ID}":
            return

        if not self.shopOrderRequest.success:
            return self.fail()

        if self.process_invoice():
            return self.success()

        return self.fail()
