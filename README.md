Socxo AI Chatbot 🤖
AI chatbot built using Laravel 12 and OpenAI API, featuring user authentication, multiple chat sessions, sidebar chat history, and token limit enforcement.

✨ Features

✅ User Authentication (Laravel Breeze)
✅ Register & Login UI
✅ Dashboard UI
✅ ChatGPT-style Chat Interface
✅ Multiple Chat Sessions
✅ Sidebar Chat History
✅ Resume Previous Conversations
✅ New Chat Creation
✅ Token Limit Enforcement (20,000 tokens per chat)
✅ Secure OpenAI API Integration


🛠️ Tech Stack

Backend: Laravel 12, PHP 8.2
Frontend: Blade, Bootstrap 5, jQuery
Database: MySQL
Authentication: Laravel Breeze
AI Model: OpenAI gpt-3.5-turbo


📸 UI Screenshots
Register UI
Show Image
Login UI
Show Image
Dashboard UI
Show Image
Chat Interface
Show Image

🚀 Installation & Setup
1️⃣ Clone the Repository
bashgit clone https://github.com/Manojs-developer/Socxo.git
cd Socxo
2️⃣ Install PHP Dependencies
bashcomposer install
3️⃣ Configure Environment
bashcp .env.example .env
Update database credentials in .env:
envDB_DATABASE=chatbox_db
DB_USERNAME=root
DB_PASSWORD=
Add OpenAI API key:
envOPENAI_API_KEY=your_openai_api_key_here
4️⃣ Generate Application Key
bashphp artisan key:generate
5️⃣ Run Database Migrations
bashphp artisan migrate
6️⃣ Install Frontend Dependencies
bashnpm install
7️⃣ Build Frontend Assets
bashnpm run dev
8️⃣ Start the Development Server
bashphp artisan serve
Visit: http://localhost:8000

⚠️ Why Node.js and npm are Used
Although this project is built using Laravel (PHP), Node.js and npm are required only for frontend asset management, not for backend development.
Laravel uses Vite as a modern build tool to compile and bundle frontend assets such as:

CSS files
JavaScript files
Bootstrap styles
jQuery scripts

Key Points

Node.js is required to run Vite
npm is used to install frontend dependencies
No backend logic is written in Node.js
All core functionality (authentication, database, chat logic, OpenAI integration) is implemented using Laravel (PHP)

Usage in This Project
Node.js and npm are used only for:
bashnpm install      # Install frontend dependencies
npm run dev      # Compile assets for development
npm run build    # Build assets for production

🔐 Authentication (Laravel Breeze)
This project uses Laravel Breeze for authentication.
Included Features:

User Registration
User Login
Secure Logout
Middleware-protected routes


💬 Chat System Architecture

Each conversation has a unique chat_session_id
Messages stored in messages table
Sidebar displays previous chat sessions
Clicking a chat resumes the conversation


🤖 OpenAI Integration

API Endpoint: /v1/chat/completions
Model Used: gpt-3.5-turbo
Max tokens per response: 500


📊 Token Limit Enforcement

Maximum 20,000 tokens per chat
Tokens calculated using message length
User is prompted to start a new chat after the limit is reached


📝 License
This project is open-source and available under the MIT License.

🤝 Contributing
Contributions, issues, and feature requests are welcome!

👨‍💻 Author
Manoj S
GitHub: @Manojs-developer

🙏 Acknowledgments

Laravel Framework
OpenAI API
Bootstrap
jQuery
