# Apna Kisaan API

Import `postman/Apna-Kisaan-API.postman_collection.json` into Postman.

## Base URL

Local Laravel server:

```text
http://127.0.0.1:8000/api
```

For another environment, change the collection variable `base_url`.

## Authentication

1. Run `Authentication > Login and save token`.
2. The Postman test script saves the returned token as `api_token`.
3. Protected requests send `Authorization: Bearer {{api_token}}`.

The seeded local accounts are:

- User: `user@apnakisaan.in` / `User@123456`
- Admin: `admin@apnakisaan.in` / `Admin@123456`

The API returns JSON in this shape for normal responses:

```json
{
    "success": true,
    "message": "...",
    "data": {}
}
```

Validation failures return HTTP 422. Invalid credentials or missing tokens return HTTP 401.

## Endpoints

| Method | Endpoint                | Auth   | Purpose                                     |
| ------ | ----------------------- | ------ | ------------------------------------------- |
| POST   | `/register`             | No     | Create a farmer account and receive a token |
| POST   | `/login`                | No     | Login and receive a token                   |
| POST   | `/logout`               | Bearer | Revoke the current token                    |
| GET    | `/profile`              | Bearer | Fetch the logged-in user                    |
| GET    | `/services`             | No     | List active services                        |
| GET    | `/services/{id}`        | No     | Fetch one service                           |
| GET    | `/districts`            | No     | List active MP districts                    |
| GET    | `/market-price`         | No     | Fetch market prices                         |
| GET    | `/vegetable-price`      | No     | Fetch vegetable prices                      |
| GET    | `/crop-price`           | No     | Fetch crop prices                           |
| POST   | `/inquiries`            | No     | Submit a contact inquiry                    |
| POST   | `/farmer-registrations` | No     | Submit farmer or buyer registration         |
| POST   | `/transport-bookings`   | No     | Submit a transport booking                  |

All POST requests should send `Accept: application/json` and `Content-Type: application/json`.

## Form payloads

`POST /inquiries` requires `name`, `phone`, and `message`. Optional fields: `district`, `subject`, `vegetable`.

`POST /farmer-registrations` requires `type` (`farmer` or `buyer`), `name`, and `mobile`. Optional fields include `district`, `village`, and `main_crop`.

`POST /transport-bookings` requires `pickup_location`, `delivery_location`, `vehicle_type` (`truck`, `pickup`, or `cold`), `crop_name`, `quantity`, `preferred_date`, and `mobile`.
