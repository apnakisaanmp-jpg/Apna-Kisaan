# Apna Kisaan API

Import [`../postman/Apna-Kisaan.postman_collection.json`](../postman/Apna-Kisaan.postman_collection.json) into Postman. The collection defaults to `http://127.0.0.1:8000`; change its `base_url` collection variable for another environment. API routes are prefixed with `/api`.

## Request and response conventions

- Send `Accept: application/json` on every request.
- Send `Content-Type: application/json` on JSON `POST` requests.
- Protected endpoints use `Authorization: Bearer <token>`.
- Successful resource endpoints use `{ "success": true, "message": "...", "data": ... }`. Market-price endpoints additionally return `records`, `total`, `meta`, `source`, `attribution`, and `updated`.
- Validation errors return HTTP `422` with Laravel's `message` and field-keyed `errors`. Invalid/missing tokens return `401`; disabled accounts return `403`.
- Tokens are shown only at registration/login and stored hashed in the database. Keep the returned token private. Logout revokes only the token used for that request.

## Authentication

| Method | Endpoint | Auth | Purpose |
| --- | --- | --- | --- |
| POST | `/api/register` | No | Create account and issue a Bearer token |
| POST | `/api/login` | No | Sign in and issue a Bearer token |
| GET | `/api/profile` | Bearer | Get the signed-in user's safe profile |
| POST | `/api/logout` | Bearer | Revoke the current token |

Registration JSON:

```json
{
  "name": "Demo Farmer",
  "email": "farmer@example.com",
  "mobile": "9876543210",
  "password": "secure-pass-123",
  "password_confirmation": "secure-pass-123",
  "device_name": "android-app"
}
```

`device_name` is optional and labels the token for device management. A login body uses `email`, `password`, and optionally `device_name`. Registration signs up a regular user; it cannot create an admin.

## Public content

| Method | Endpoint | Purpose |
| --- | --- | --- |
| GET | `/api/services` | Active services from the database |
| GET | `/api/services/{slug}` | One active service |
| GET | `/api/districts` | Active districts ordered for display |
| GET | `/api/districts/{slug}` | One active district |
| GET | `/api/crop-categories` | Active crop categories |
| GET | `/api/faqs?page=home` | Active FAQ records; `page` is optional |
| GET | `/api/sliders` | Active homepage slides |

These endpoints use current database content, not hard-coded demo records. Seed/manage the corresponding Laravel data to populate them.

## Market prices

| Method | Endpoint | Data |
| --- | --- | --- |
| GET | `/api/mandi-bhav` | All supported market records |
| GET | `/api/market-price` | Compatibility alias for market records |
| GET | `/api/vegetable-price` | Vegetable records |
| GET | `/api/crop-price` | Crop records |
| GET | `/api/prices/{type}` | `market`, `vegetable`, or `crop`; type defaults to `market` |

Price data is fetched and cached by `FarmerPriceService` from the farmer.in open agriculture feed. The response identifies its `source`, `attribution`, update timestamp, and whether it is `meta.is_fallback`. When the upstream feed is unavailable, the configured local examples are returned with fallback metadata; do not treat those examples as current exchange prices.

Supported query parameters (combine as needed):

| Parameter | Meaning | Example |
| --- | --- | --- |
| `q` | Case-insensitive search in Hindi/English commodity, market, district, and category names | `?q=wheat` |
| `category` | Partial category match | `?category=अनाज` |
| `min_price`, `max_price` | Inclusive modal-price bounds | `?min_price=1000&max_price=5000` |
| `is_mp` | `1` or `0`, based on the feed's state/relevance classification | `?is_mp=1` |
| `trend` | `up`, `down`, or `same` | `?trend=up` |
| `sort` | `commodity`, `modal_price`, or `arrival_date` | `?sort=modal_price&order=desc` |
| `order` | `asc` or `desc` (default `asc` when sorting) | `?order=desc` |
| `page` | 1-based page number (default `1`) | `?page=2` |
| `per_page` | Page size from 1 to 100 (default `20`) | `?per_page=25` |

Example:

```http
GET /api/mandi-bhav?q=wheat&is_mp=1&min_price=1000&sort=modal_price&order=desc&page=1&per_page=20
Accept: application/json
```

`records` contains only the requested page. `total` and `meta.last_page` describe the filtered result set. The upstream feed does not guarantee actual mandi- and district-level prices; the API does not fabricate them. Use `/api/districts` for district content, not as a claim that each price row is a verified quote from that district.

## Public forms

These public endpoints create leads/requests; they do not require a user token.

| Method | Endpoint | Required fields |
| --- | --- | --- |
| POST | `/api/inquiries` | `name`, `phone`, `message`; optional `district`, `subject`, `vegetable` |
| POST | `/api/farmer-registrations` | `type`, `name`, `mobile`; farmer requires `district`, `main_crop`; buyer requires `business_type`, `city`, `required_crop`, `required_quantity` |
| POST | `/api/transport-bookings` | `pickup_location`, `delivery_location`, `vehicle_type`, `crop_name`, `quantity`, `preferred_date`, `mobile` |

Farmer form example:

```json
{
  "type": "farmer",
  "name": "Demo Farmer",
  "mobile": "9876543210",
  "district": "दमोह",
  "village": "उदाहरण गांव",
  "main_crop": "गेहूं",
  "farm_area": 3.5
}
```

Buyer form example:

```json
{
  "type": "buyer",
  "name": "Demo Buyer",
  "mobile": "9876543210",
  "business_type": "थोक व्यापारी",
  "city": "भोपाल",
  "required_crop": "टमाटर",
  "required_quantity": 25
}
```

Transport `vehicle_type` values are `truck`, `pickup`, and `cold`. `preferred_date` must be today or later, formatted as `YYYY-MM-DD`; quantity is in quintals.

## Signed-in inquiries

| Method | Endpoint | Auth | Purpose |
| --- | --- | --- | --- |
| POST | `/api/my/inquiries` | Bearer | Create an inquiry owned by the signed-in user |
| GET | `/api/my/inquiries` | Bearer | List only that user's inquiries and replies |

Create body:

```json
{
  "subject": "Transport request update",
  "message": "Please contact me about my transport request.",
  "phone": "9876543210"
}
```

## Postman quick start

1. Start Laravel with `php artisan serve`.
2. Import the collection JSON.
3. Set `base_url` if the server address differs.
4. Run **Register** with a unique email, or run **Login** with an existing account. The collection saves the returned token automatically.
5. Use **My profile**, **Create my inquiry**, and **List my inquiries** to exercise protected APIs.
6. Use the price requests to exercise live feed/fallback handling, filters, and pagination.

The collection's example form submissions create real records in the configured database. Use a local/test environment and sample data when exercising those POST requests.
