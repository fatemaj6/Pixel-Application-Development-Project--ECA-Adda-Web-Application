---

# 📘 ECA Adda – Web Application

ECA Adda is a Laravel-based web application that allows students to explore and enroll in extracurricular activities (ECAs). The system supports role-based access (students and admins), OTP-based authentication, tier-based payments using Stripe, Gemini and Calendly integrations for AI chatbot and scheduling sessions as well as integrated google calenders. 

---

## 🛠️ Tech Stack

* *Backend:* Laravel 12 (PHP 8.2)
* *Frontend:* Blade + Node.js + Vite 
* *Database:* MySQL (via XAMPP)
* *Payment Gateway:* Stripe Sandbox
* *AI Chatbot:* Google Gemini
* *One-to-One Session:* Calendly
* *Personalized Calendar:* Google Calendar
* *Authentication:* Email OTP with Brevo

---

## 📁 Prerequisites

Before running the project, ensure the following are installed:

* PHP *8.2+*
* Composer
* Node.js & npm
* XAMPP (Apache + MySQL)
* Git (optional but recommended)

---

## ⚙️ Project Setup Instructions

### 1️⃣ Clone or Extract the Project

If using Git:

bash
git clone <repository-url>
cd ECA-Adda


If using ZIP (better since several necessary files are not uploaded to GitHub):

* Extract the project folder
* Open the folder in *VS Code*
* Open terminal inside the project root

---

### 2️⃣ Install PHP Dependencies (Laravel)

composer install

---

### 3️⃣ Install Frontend Dependencies

npm install

---

### 4️⃣ Environment Configuration

Create .env file:
copy .env.example .env

Update .env with your local configuration (submitted our .env variables as a doc with other project documents)

---

### 5️⃣ Generate Application Key

php artisan key:generate

---

### 6️⃣ Database Setup

1. Open *XAMPP Control Panel*
2. Start *Apache* and *MySQL*
3. Open *phpMyAdmin*
4. Create a database named:  eca_adda
   

Run migrations and seeders:


php artisan migrate
php artisan db:seed


---

### 7️⃣ Storage & Assets Setup


php artisan storage:link


---

### 8️⃣ Compile Frontend Assets


npm run dev


(We used npm run build for production)

---

### 9️⃣ Run the Application


php artisan serve


Open browser:


http://127.0.0.1:8000


---

## 👥 User Roles

### 👩‍🎓 Student

* Register with Admin's Approval
* Select Subscription Tier (Tier 1 / Tier 2)
* Make payment via Stripe
* Login with OTP
* Browse & enroll in ECAs
* View enrolled ECAs

### 🛡️ Admin

* Login with OTP
* Manage ECAs (CRUD)
* View student enrollments
* Approve registrations



