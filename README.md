# TaskForInterview
Technalogies:
Laravel
PostgreSql
JWT auth
ElasticSearch
Run in Docker Compose
# Laravel JWT Auth + Elasticsearch + Postgres + Docker

## 🚀 How to Run
1. Clone this repository:
2. Start the project with Docker:
- docker-compose up -d --build
3. Run migrations:
- docker-compose exec app php artisan migrate
4. ## 📌 API Endpoints
### Authentication (JWT)
- **Register**: `POST /api/register`
- **Login**: `POST /api/login`
- **Category Store and Product Store** 
- Copy the token after successful login and put on headers
  Key: Authorization
  Value: Bearer your_token
- `POST /api/category/store`
- `POST /api/product/store`
### Elasticsearch
- **Index a Product**: `POST /api/product/store`
- **Search Products**: `GET /api/products/product/search?query=title_of_product`
