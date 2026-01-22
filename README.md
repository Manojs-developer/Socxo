# Socxo AI Chatbot

A ChatGPT-style AI chatbot built with Laravel, featuring multiple chat sessions, sidebar chat history, and token limit enforcement.

## Features

- User authentication
- Sidebar with previous chats
- Resume previous conversations
- New Chat button
- Token limit enforcement per chat (20,000 tokens)
- OpenAI integration

## Tech Stack

- Laravel 12
- PHP 8.2
- MySQL
- Bootstrap 5
- jQuery
- OpenAI API

## Screenshots

![Register Ui](https://raw.githubusercontent.com/Manojs-developer/Socxo/main/screenshots/register.png)
![Login Ui](https://raw.githubusercontent.com/Manojs-developer/Socxo/main/screenshots/login.png)
![Dashboard Ui](https://raw.githubusercontent.com/Manojs-developer/Socxo/main/screenshots/dashboard.png)
![Chat Ui](https://raw.githubusercontent.com/Manojs-developer/Socxo/main/screenshots/dashboard_2.png)

## Installation
```bash
git clone https://github.com/Manojs-developer/Socxo.git
cd Socxo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
npm run dev
```

## Configuration

Add your OpenAI API key to `.env`:
```
OPENAI_API_KEY=your_api_key_here
```
