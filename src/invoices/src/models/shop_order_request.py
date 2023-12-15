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


class ShopOrderRequest(BaseModel):
    groupId: str
    success: bool
    shopOrderRequestData: ShopOrderRequestData
