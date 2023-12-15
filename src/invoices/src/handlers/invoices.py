from pydantic import BaseModel
from src.models.shop_order_request import ShopOrderRequest

MAX_INVOICE_LEN = 60


class InvoicesHandler(BaseModel):
    """Invoices microservice handler"""
    shop_order_request: ShopOrderRequest

    def success(self):
        """Success path"""
        self.shop_order_request.success = True
        # TODO: topic handler -> ship orders

    def fail(self):
        """Failure path"""
        self.shop_order_request.success = False
        # TODO: topic handler -> shipments

    def generate_invoice(self):
        """UUID + Customer + Product"""
        data = self.shop_order_request.shop_order_request_data
        invoice: str = data.uuid + data.customer + data.product

        self.shop_order_request.shop_order_request_data.invoice = invoice

    def is_valid_invoice(self):
        """Should not surpass the max amount"""
        return len(self.shop_order_request.shop_order_request_data.invoice) <= MAX_INVOICE_LEN

    def process_invoice(self):
        """Actual invoice processing"""
        self.generate_invoice()
        return self.is_valid_invoice()

    def process(self):
        """Orchestrator"""
        if not self.shop_order_request.success:
            return self.fail()

        if self.process_invoice():
            return self.success()

        return self.fail()
