# 🗂️ Stack Framework

**Stack Framework** is a lightweight, minimal PHP framework built with **SQLite3**, designed for fast backend development with clean architecture and easy API/logic integration.

---

## ⚡ **Features**

- 🚀 Minimal setup, no Composer required
- 📂 Clean folder structure
- 🔗 Automatic routing based on `public/` files
- 🗃️ Built-in SQLite database connection
- 🔑 Session management
- 🛠️ Helper functions for JSON APIs
- 🤖 Integrated AI helper (`ai.php`)
- 🔐 Authentication logic ready (`auth.php`, `regUsers.php`)
- ✉️ Email OTP verification ready (`js-pack/email.js`)
- 🔍 Easy to extend with your own logic modules

---

## 📁 **Project Structure**

project-root/ ├── index.php ├── .htaccess └── app/ ├── connection/ │   └── init.php ├── db/ │   └── app.sqlite ├── js-pack/ │   └── email.js ├── logic/ │   ├── ai.php │   ├── api.php │   ├── auth.php │   ├── helpers.php │   ├── regUsers.php │   ├── router.php │   └── session.php └── public/ ├── about.php ├── footer.php ├── header.php └── home.php

---

## ⚙️ **How Routing Works**

✅ **index.php** acts as the front controller:

1. Loads `connection/init.php` for DB, session, and autoload setup.
2. Gets `?route=page` from URL or defaults to `home`.
3. Loads `public/page.php` if it exists.  
   - Example: `/?route=about` loads `public/about.php`

---

## 🛠️ **Using Logic Files**

Your **logic files** are in `app/logic/` and can be imported in any page:

```php
require_once __DIR__ . '/../logic/auth.php';

✅ Best practice: only include needed logic in each page to keep execution clean.


---

🤖 Using AI Helper

ai.php integrates Stack AI


Example:

require_once __DIR__ . '/../logic/ai.php';

$userId = 'test-user';
$userMessage = 'Hello AI!';
$aiReply = fetchStackVerifyAI($userId, $userMessage);

echo $aiReply;


---

🔑 Authentication & Registration

auth.php – general authentication logic

regUsers.php – user registration logic with DB write


Example usage in API endpoint:

require_once __DIR__ . '/../logic/regUsers.php';
register_user($db, $_POST);


---

✉️ Email OTP Integration

In js-pack/email.js you will find ready logic to integrate with your OTP service.


Usage:

1. Include in your registration or forgot password page


2. Call its functions to request and verify OTP




---

📦 Database Connection

Defined in connection/init.php using PDO SQLite3:


$db = new PDO('sqlite:' . __DIR__ . '/../db/app.sqlite');

✅ Replace with MySQL or Postgres if needed by editing init.php.


---

💻 Running the Framework

1. Host on PHP-supported server (Apache, Nginx, or localhost with PHP CLI).


2. Visit / – loads home.php


3. Visit /?route=about – loads about.php




---

🌟 Extending the Framework

Add your logic files under logic/

Create new pages under public/

Build API endpoints in logic/ and route requests as needed

Add frontend frameworks as static assets if desired



---

📝 Final Notes

✅ No complex config – edit init.php for DB settings
✅ No Composer dependencies – pure PHP
✅ Works with any frontend – Vanilla JS, React, Vue, etc.


---

Built for speed, simplicity, and freedom.
Enjoy using Stack Framework in your projects!


---

🔗 License

MIT License (modify as needed)

