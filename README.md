# Online-Bookstore-Web-App

This project is a **Laravel-based e-commerce web app** for buying and selling books online.  
It simulates a real-world bookstore experience — users can list their books for sale, browse others’ listings, and place simulated orders.  

This project demonstrates the **core concepts of full-stack Laravel development**, including MVC architecture, routing, authentication, migrations, validation, and CRUD operations.

---

##  Objective
To develop a scalable and user-friendly online platform that allows users to **buy and sell books**, while applying Laravel’s **MVC framework**, database management, and web development best practices.

---

##  Problem Statement
Traditional bookstores and marketplaces are often limited by location, inventory, or trust issues.  
YourBook solves this by creating a **centralized digital bookstore**, where verified users can easily manage book listings, search for titles, and place orders — all from a browser.

---

##  Tools and Technologies Used

| Category | Tools / Frameworks |
|-----------|--------------------|
| **Backend Framework** | Laravel 9.x |
| **Programming Language** | PHP 8+ |
| **Frontend** | Blade Templates (HTML, CSS, Bootstrap) |
| **Database** | MySQL |
| **Authentication** | Laravel Breeze / Built-in Auth |
| **Development Tools** | Composer, Artisan CLI, XAMPP |
| **Version Control** | Git & GitHub |
| **Key Concepts** | MVC Architecture, Routing, Eloquent ORM, Validation, Sessions, Middleware |

---

##  System Design

YourBook follows the **MVC (Model-View-Controller)** pattern.

### **Models**
- `User` – manages buyers and sellers  
- `Book` – handles book listings  
- `Order` & `OrderItem` – manage simulated purchases

### **Controllers**
- `BookController` – CRUD operations for books  
- `OrderController` – handles checkout and order storage  
- `CartController` – manages shopping cart logic  

### **Views (Blade Templates)**
- `books/index.blade.php` – book listing  
- `books/create.blade.php` – form to add a book  
- `orders/index.blade.php` – order history page  

---

##  Database Structure

| Table | Description |
|--------|--------------|
| `users` | Stores user information (name, email, password, role) |
| `books` | Stores book details added by sellers |
| `orders` | Records placed orders (simulated payment) |
| `order_items` | Stores individual items in each order |

### **Relationships**
- One `user` → many `books`  
- One `user` → many `orders`  
- One `order` → many `order_items`  
- One `book` → many `order_items`

---

##  Flow of Execution

1. **User registers or logs in**  
2. **Seller adds books** using the book form  
3. **Buyer browses books** on the homepage  
4. Buyer clicks **Buy Now**, quantity is confirmed  
5. The system **simulates payment** and stores the order  
6. **Order details** can be viewed in the “My Orders” page  
7. **Flash message** confirms successful checkout  

---

## 📂 Project Structure
