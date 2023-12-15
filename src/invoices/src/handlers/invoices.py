from pydantic import BaseModel
from src.models.shop_order_request import ShopOrderRequest


class InvoicesHandler(BaseModel):
    shop_order_request: ShopOrderRequest

    def success(self):
        """"""

    def fail(self):
        """"""
