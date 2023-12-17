import json
from typing import Optional

from pydantic import BaseModel


class ShopOrderRequestData(BaseModel):
    uuid: str
    customer: str
    email: str
    address: str
    credit: str
    product: str
    quantity: int
    price: float
    paid: Optional[float]
    shipment: Optional[str]
    invoice: Optional[str]

    def __str__(self):
        return json.dumps({
            "uuid": self.uuid,
            "customer": self.customer,
            "email": self.email,
            "address": self.address,
            "credit": self.credit,
            "product": self.product,
            "quantity": self.quantity,
            "price": self.price,
            "paid": self.paid,
            "shipment": self.shipment,
            "invoice": self.invoice,
        })


class ShopOrderRequest(BaseModel):
    groupId: str
    success: bool
    shopOrderRequestData: ShopOrderRequestData

    def __str__(self):
        return json.dumps({
            "groupId": self.groupId,
            "success": self.success,
            "shopOrderRequestData": self.shopOrderRequestData,
        })

    @staticmethod
    def parse(raw: dict):
        return ShopOrderRequest(
            success=raw["success"],
            groupId=raw["groupId"],
            # TODO: check for parsing errors
            shopOrderRequestData=ShopOrderRequestData(
                **raw["shopOrderRequestData"]
            )
        )
