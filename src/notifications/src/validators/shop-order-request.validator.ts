import z from "zod";

const shopOrderRequestDataValidator = z.object({
  uuid: z.string(),
  customer: z.string(),
  email: z.string(),
  address: z.string(),
  credit: z.string(),
  product: z.string(),
  quantity: z.number(),
  price: z.number(),
  paid: z.number().optional(),
  shipment: z.string().optional(),
  invoice: z.string().optional(),
});

const shopOrderRequestValidator = z.object({
  groupId: z.string(),
  success: z.boolean(),
  shopOrderRequestData: shopOrderRequestDataValidator,
});

export type ShopOrderRequest = z.infer<typeof shopOrderRequestValidator>;
export type ShopOrderRequestData = ShopOrderRequest["shopOrderRequestData"];
