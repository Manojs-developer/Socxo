# Socxo AI Chatbox

An AI-powered chatbot built using **Laravel 12** and the **OpenAI API**, featuring secure user authentication, multiple chat sessions, sidebar chat history, and token limit enforcement.

---

## Features

* User Authentication (Laravel Breeze)
* Register & Login UI
* Dashboard UI
* ChatGPT-style Chat Interface
* Multiple Chat Sessions
* Sidebar Chat History
* Resume Previous Conversations
* New Chat Creation
* Token Limit Enforcement (20,000 tokens per chat)
* Secure OpenAI API Integration

---

## Tech Stack

**Backend**: Laravel 12, PHP 8.2
**Frontend**: Blade, Bootstrap 5, jQuery
**Database**: MySQL
**Authentication**: Laravel Breeze
**AI Model**: OpenAI `gpt-3.5-turbo`


##  Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/Manojs-developer/Socxo.git
cd Socxo
```

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

### 3️⃣ Configure Environment

```bash
cp .env.example .env
```

Update database credentials in `.env`:

```env
DB_DATABASE=chatbox_db
DB_USERNAME=root
DB_PASSWORD=

`Add your OpenAI API key:

```env
OPENAI_API_KEY=your_openai_api_key_here
```
``
### 3️⃣ Connect Database

Open phpMyAdmin
Create a database
Import the SQL file shared in Google Drive


### 4️⃣ Generate Application Key

```bash
php artisan key:generate
```
```bash
php artisan serve
```

Visit: **[http://localhost:8000](http://localhost:8000)**

##  Authentication (Laravel Breeze)

This project uses **Laravel Breeze** for authentication.

Included features:

* User Registration
* User Login
* Secure Logout
* Middleware-protected routes

---

##  Chat System Architecture

* Each conversation has a unique `chat_session_id`
* Messages are stored in the `messages` table
* Sidebar displays previous chat sessions
* Clicking a chat resumes the conversation

---

##  OpenAI Integration

* **API Endpoint**: `/v1/chat/completions`
* **Model Used**: `gpt-3.5-turbo`
* **Max tokens per response**: 500

---

##  Token Limit Enforcement

* Maximum **20,000 tokens per chat**
* Tokens calculated based on message length
* User is prompted to start a new chat once the limit is reached

---
