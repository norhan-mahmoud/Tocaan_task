# Tocaan Task

## Requirements

Before running the project, make sure you have the following installed:

- PHP 8.4
- Laravel 13
- Composer
- MySQL (or any supported database)

---

## Installation

Clone the repository and install the dependencies:

```bash
composer install
```

Copy the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Run the migrations and seed the database:

```bash
php artisan migrate:fresh --seed
```

Generate the JWT secret:

```bash
php artisan jwt:secret
```

Generate the API documentation:

```bash
php artisan scribe:generate
```

---

## Configuration

Configure the Paymob gateway credentials by either:

- Adding the required values to the `.env` file.
- Saving the gateway configuration in the database.

Example:

```env
PAYMOB_API_KEY=
PAYMOB_INTEGRATION_ID=
PAYMOB_IFRAME_ID=
PAYMOB_HMAC_SECRET=
```

---

## Running the Project

Start the development server:

```bash
php artisan serve
```

The application will be available at:

```
http://127.0.0.1:8000
```

---

## API Documentation

After generating the documentation, you can access it at:

```
http://your-domain/scribe
```

or locally:

```
http://127.0.0.1:8000/scribe
```

---

## Testing the API

You can test the API using any of the following:

- Postman
- Insomnia
- The generated Scribe documentation

If a Postman collection is included in the repository, simply import it and start testing the endpoints.

---

## Notes

- Ensure the database credentials are correctly configured in the `.env` file before running the migrations.
- The Paymob gateway must be configured before testing payment-related endpoints.
- Run `php artisan scribe:generate` again whenever API endpoints or documentation annotations are updated.


## Payment Gateway Extensibility

The payment module is designed to be easily extensible by using the **Strategy Pattern** and following the **SOLID** principles.

Each payment method is mapped to its corresponding gateway class inside the `PaymentMethod` enum through the `gatewayClass()` method. The `GatewayResolver` simply resolves the gateway using Laravel's service container, without containing any gateway-specific logic.

### Current Mapping

| Payment Method | Gateway |
| -------------- | ------- |
| Visa           | Paymob  |
| Mastercard     | Paymob  |
| Meeza          | Paymob  |
| Wallet         | Paymob  |
| TBC            | Paymob  |
| Cash           | Paymob  |
| Apple Pay      | Stripe  |

### How to Add a New Payment Gateway

1. Create a new gateway class that implements `PaymentGatewayInterface`.
2. Add the required gateway configuration (API keys, secrets, etc.) in the `.env` file or database.
3. Register the new payment method in the `PaymentMethod` enum and map it to the gateway class using the `gatewayClass()` method.

Example:

```php
case GOOGLE_PAY = 'google_pay';

public function gatewayClass(): string
{
    return match ($this) {
        self::GOOGLE_PAY => GooglePayGateway::class,
        // ...
    };
}
```

No changes are required in the controllers, services, or `GatewayResolver`. The resolver automatically instantiates the correct gateway based on the mapping defined in the enum, making the system easy to extend while complying with the Open/Closed Principle (OCP).

