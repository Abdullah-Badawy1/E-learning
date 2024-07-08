# Web Application Overview

This README provides an overview of the web application, including its components and interactions.

## Application Diagram

```plaintext
+----------------------------+
| Client (Browser)           |
|                            |
| +------------------------+ |
| | HTML Pages             | |
| | - index.html           | |
| | - home/index.html      | |
| |                        | |
| | JavaScript (scripts.js)| |
| +------------------------+ |
|           |                 |
|           v                 |
|  HTTP Requests/Responses    |
|           |                 |
|           v                 |
+----------------------------+
           |
           v
+----------------------------+
| Server (LAMP Stack)        |
|                            |
| +------------------------+ |
| | PHP Scripts            | |
| | - db.php               | |
| | - login.php            | |
| | - register.php         | |
| | - reset_password.php   | |
| | - logout.php           | |
| +------------------------+ |
|           |                 |
|           v                 |
|   Database Interaction      |
|           |                 |
|           v                 |
| +------------------------+ |
| | MySQL Database         | |
| | - login_db             | |
| |   - users Table        | |
| +------------------------+ |
+----------------------------+

