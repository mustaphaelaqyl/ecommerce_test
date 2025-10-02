# E-commerce Order Management System (Backend)

This is a **Laravel 8** backend for an **E-commerce Order Management System**.  
It supports user authentication, role-based access (admin/customer), product & category management, cart & order processing, payments, notifications, caching, and queues.

---

## **Features**

- User Authentication: Register, Login, Logout (Sanctum)
- Role-based access control (Admin/Customer)
- Category & Product management
- Customer Cart & Orders
- Mock Payments
- Middleware for stock check
- Service class for order creation and discount calculation
- Notifications (email & database) with queues
- Caching for product listings x
- Fully tested with Feature & Unit tests x

---

## **Seeded Data**

- Users:
  - 2 Admins
  - 10 Customers
- Categories: 5
- Products: 20
- Carts: 10
- Orders: 15

---

## **Setup Instructions**

### 1. Clone the repository
```bash
git clone https://github.com/mustaphaelaqyl/ecommerce_test.git
cd ecommerce_test
