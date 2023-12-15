# Choreography Microservices

Event-Driven Microservices with Kafka and Choreography as the consistency pattern

## Why

### Source

https://github.com/ccsw-csd/shop-cart-public

### Reference

https://github.com/ccsw-csd/shop-cart

## Structure

Crear dos carpetas, escritos y src (para todos los micros)

## Language Philosophy

Para lo del laboratorio de la charla de microa usar los siguientes lenguajes, intentando evitar Java si es posible

- Ruby -> shop_orders
- C# -> stocks
- Golang -> payments
- PHP -> shipments
- Python -> invoices
- Node -> notifications

## Testing

Y archivos y jsons por vertical de e2e testing en su propio lenguaje
Con un script para ejecutarlos todos

## Handlers

```java
class ServiceHandler {
    public ShopOrderRequest shopOrderRequest;

    // ...

    public void success() {

    }

    public void fail() {

    }
}
```
