<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>




# Socxo AI Chatbot 

A ChatGPT-style AI chatbot built with Laravel, featuring:
- Multiple chat sessions
- Sidebar chat history
- New chat creation
- Token limit per chat (20,000)
- Clean UI similar to ChatGPT

---

##  Features
- User authentication
- Sidebar with previous chats
- Resume previous conversations
- New Chat button
- Token limit enforcement per chat
- OpenAI integration

---

##  Tech Stack
- Laravel 12
- PHP 8.2
- MySQL
- Bootstrap 5
- jQuery
- OpenAI API

---

![Register Ui](screenshots/register.png)
![Login Ui](screenshots/login.png)
![Dashboard Ui](screenshots/dashboard.png)
![Chat Ui](screenshots/dashboard_2.png)

##  Installation Steps

```bash
git clone https://github.com/Manojs-developer/Socxo.git
cd Socxo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

npm run dev

