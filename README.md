# Laravel Microservices E-commerce Platform

A modern, scalable e-commerce platform built using Laravel microservices architecture. Each service is independently deployable and communicates via REST APIs.

## 🎯 My Approach

I designed this system with **separation of concerns** in mind:
- **User Service**: Handles authentication, authorization, and user management
- **Product Service**: Manages product catalog, categories, and inventory
- **Order Service**: Processes orders, payments, and order lifecycle
- **Shared Database per Service**: Each microservice has its own database for data isolation
- **Docker Containerization**: Easy deployment and development consistency
- **Nginx Reverse Proxy**: Unified API gateway for all services


## 🚀 Quick Setup

### Prerequisites
- Docker
- Docker Compose

### Installation

1. **Clone the repository**
   ```bash
git clone https://github.com/AhmedRamadan03/ecommerce-task.git
cd ecommerce-task

docker-compose up -d --build

# User Service
docker-compose exec user-service php artisan migrate 

# Product Service
docker-compose exec product-service php artisan migrate 

# Order Service  
docker-compose exec order-service php artisan migrate 


## 📡 API Endpoints

### Authentication (User Service)
POST /auth/register
POST /auth/login
GET /auth/profile


### Categories (Product Service)
GET /categories
POST /categories (Admin/Seller)
PUT /categories/{id} (Admin/Seller)
DELETE /categories/{id} (Admin/Seller)

### Products (Product Service)
GET /products
get products/{id}/stock 
patch products/{id}/update-stock 
POST /products (Admin/Seller)
PUT /products/{id} (Admin/Seller)
DELETE /products/{id} (Admin/Seller)

### Orders (order Service)
GET /admin/orders (Admin/Seller)
patch orders/{id}/status (admin/seller) 
get orders  customer
POST /orders customer


