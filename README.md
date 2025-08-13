# 🎮 GameStore

A comprehensive web-based video game store application built with PHP and PostgreSQL. Users can browse, purchase, and manage their game library with a modern, responsive interface.

## 🌟 Features

### User Authentication
- **User Registration**: Create new accounts with email validation
- **User Login**: Secure authentication system
- **Admin Access**: Special admin privileges for game management
- **Session Management**: Secure user sessions throughout the application

### Game Browsing & Management
- **Store Page**: Browse all available games with detailed information
- **Game Details**: View comprehensive game information including:
  - Description, release date, developer, publisher
  - Platform compatibility, pricing, ratings, and reviews
- **Admin Panel**: Add new games to the store (admin only)

### User Library
- **Personal Library**: View all purchased games
- **Game History**: Track purchase dates and game details
- **Interactive Interface**: Click on games for detailed information in modal windows

### Transaction System
- **Secure Purchasing**: Buy games with multiple payment options
- **Payment Methods**: Support for Credit Card, PayPal, and Bank Transfer
- **Purchase Prevention**: Prevents duplicate purchases of owned games
- **Transaction History**: Complete record of all purchases with payment details

### Modern UI/UX
- **Responsive Design**: Bootstrap 5 integration for mobile-friendly interface
- **Dark Theme**: Modern dark color scheme
- **Interactive Elements**: Hover effects and smooth transitions
- **Navigation**: Intuitive navigation bar with easy access to all features

## 🛠️ Technology Stack

### Backend
- **PHP**: Server-side scripting and business logic
- **PostgreSQL**: Robust database management system
- **Session Management**: PHP sessions for user authentication

### Frontend
- **HTML5**: Modern semantic markup
- **CSS3**: Custom styling with Bootstrap integration
- **JavaScript**: Interactive client-side functionality
- **Bootstrap 5**: Responsive CSS framework

### Database Schema
- **User Table**: User account information
- **Game Table**: Game catalog with detailed metadata
- **Library Table**: User-owned games relationship
- **Transaction Table**: Purchase history and payment records

## 📁 Project Structure

```
GameStore/
├── index.php           # Landing page with game listings
├── login.php           # User authentication
├── register.php        # User registration
├── dashboard.php       # User library interface
├── storepage.php       # Game store browsing
├── game.php            # Individual game details
├── buy.php             # Purchase processing
├── transaction.php     # Transaction history
├── admin.php           # Admin panel for game management
├── logout.php          # Session termination
├── connection.php      # Database configuration
├── style.css           # Custom CSS styles
├── script.js           # Client-side JavaScript
└── README.md           # Project documentation
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.4 or higher
- PostgreSQL 12 or higher
- Web server (Apache/Nginx) or local development environment

## 🖥️ Running the Project Locally

### Method 1: Using XAMPP (Recommended for Beginners)

1. **Download and Install XAMPP**
   - Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Install XAMPP with Apache and PHP components

2. **Install PostgreSQL**
   - Download PostgreSQL from [https://www.postgresql.org/download/](https://www.postgresql.org/download/)
   - Install with default settings and remember the superuser password

3. **Setup Project Files**
   ```bash
   # Clone or download the project
   git clone <repository-url>
   # Or download and extract the ZIP file
   
   # Copy project files to XAMPP htdocs folder
   cp -r GameStore/ C:/xampp/htdocs/
   # On Windows: Copy the GameStore folder to C:\xampp\htdocs\
   ```

4. **Start Services**
   - Open XAMPP Control Panel
   - Start **Apache** service
   - PostgreSQL should be running as a Windows service

5. **Access the Application**
   - Open web browser
   - Navigate to: `http://localhost/GameStore/`

### Method 2: Using Built-in PHP Server

1. **Install PostgreSQL**
   - Follow PostgreSQL installation instructions above

2. **Setup Project Directory**
   ```bash
   # Navigate to your project directory
   cd path/to/GameStore
   
   # Start PHP built-in server
   php -S localhost:8000
   ```

3. **Access the Application**
   - Open web browser
   - Navigate to: `http://localhost:8000/`

### Method 3: Using WAMP/MAMP (Windows/Mac)

1. **Install WAMP (Windows) or MAMP (Mac)**
   - WAMP: [http://www.wampserver.com/](http://www.wampserver.com/)
   - MAMP: [https://www.mamp.info/](https://www.mamp.info/)

2. **Install PostgreSQL separately** (as WAMP/MAMP typically comes with MySQL)

3. **Setup Project**
   - Copy GameStore folder to `www` (WAMP) or `htdocs` (MAMP) directory
   - Start all services from WAMP/MAMP control panel

4. **Access the Application**
   - WAMP: `http://localhost/GameStore/`
   - MAMP: `http://localhost:8888/GameStore/`

## 🗄️ Database Setup
## 🗄️ Database Setup

### Step 1: Create Database and Tables

1. **Open PostgreSQL Command Line (psql)**
   ```bash
   # On Windows (if PostgreSQL is in PATH)
   psql -U postgres
   
   # Or use pgAdmin (GUI tool) that comes with PostgreSQL
   ```

2. **Create Database** (Optional - you can use the default 'postgres' database)
   ```sql
   CREATE DATABASE gamestore;
   \c gamestore;  -- Connect to the new database
   ```

3. **Create Tables**
   ```sql
   -- User table
   CREATE TABLE "User" (
       userid SERIAL PRIMARY KEY,
       username VARCHAR(50) UNIQUE NOT NULL,
       "Password" VARCHAR(100) NOT NULL,
       email VARCHAR(100) UNIQUE NOT NULL
   );

   -- Game table
   CREATE TABLE game (
       gameid SERIAL PRIMARY KEY,
       title VARCHAR(100) NOT NULL,
       description TEXT,
       releasedate DATE,
       developer VARCHAR(50),
       publisher VARCHAR(50),
       platform VARCHAR(50),
       price DECIMAL(10,2),
       rating INTEGER CHECK (rating >= 1 AND rating <= 10),
       review TEXT
   );

   -- Library table (user-owned games)
   CREATE TABLE "Library" (
       libraryid SERIAL PRIMARY KEY,
       userid INTEGER REFERENCES "User"(userid),
       gameid INTEGER REFERENCES game(gameid),
       purchasedate TIMESTAMP DEFAULT NOW()
   );

   -- Transaction table
   CREATE TABLE "Transaction" (
       transactionid SERIAL PRIMARY KEY,
       userid INTEGER REFERENCES "User"(userid),
       gameid INTEGER REFERENCES game(gameid),
       purchasedate TIMESTAMP DEFAULT NOW(),
       amountpaid DECIMAL(10,2),
       paymentmethod VARCHAR(20)
   );
   ```

4. **Insert Sample Data** (Optional)
   ```sql
   -- Insert admin user
   INSERT INTO "User" (username, "Password", email) 
   VALUES ('admin', '12345', 'admin@gamestore.com');

   -- Insert sample games
   INSERT INTO game (title, description, releasedate, developer, publisher, platform, price, rating, review) 
   VALUES 
   ('The Witcher 3', 'Open-world RPG adventure', '2015-05-19', 'CD Projekt RED', 'CD Projekt', 'PC/PS4/Xbox', 29.99, 9, 'Masterpiece of storytelling'),
   ('Cyberpunk 2077', 'Futuristic open-world RPG', '2020-12-10', 'CD Projekt RED', 'CD Projekt', 'PC/PS4/Xbox', 49.99, 7, 'Ambitious but flawed'),
   ('Minecraft', 'Sandbox building game', '2011-11-18', 'Mojang Studios', 'Microsoft', 'PC/Mobile/Console', 26.95, 10, 'Endless creativity');
   ```

### Step 2: Configure Database Connection

1. **Update connection.php**
   ```php
   <?php
   // Configuration
   $db_host = 'localhost';
   $db_username = 'postgres';          // Your PostgreSQL username
   $db_password = 'your_password';     // Your PostgreSQL password
   $db_name = 'gamestore';            // Your database name (or 'postgres' for default)
   
   // Connect to database
   $conn = pg_connect("host=$db_host port=5432 dbname=$db_name user=$db_username password=$db_password");
   
   // Check connection
   if (!$conn) {
       echo "Error: Unable to connect to database";
       exit;
   }
   ?>
   ```

## 🎯 Quick Start Guide

### For First-Time Setup

1. **Install Prerequisites**
   - Install XAMPP or your preferred local server
   - Install PostgreSQL

2. **Get the Project**
   ```bash
   # Download/clone to your web server directory
   # XAMPP: C:\xampp\htdocs\GameStore\
   # WAMP: C:\wamp64\www\GameStore\
   # MAMP: /Applications/MAMP/htdocs/GameStore/
   ```

3. **Setup Database**
   - Follow the database setup steps above
   - Update `connection.php` with your database credentials

4. **Start Services**
   - Start Apache (via XAMPP/WAMP/MAMP control panel)
   - Ensure PostgreSQL service is running

5. **Test the Application**
   - Open browser: `http://localhost/GameStore/`
   - Create a new user account or login with admin credentials
   - Admin credentials: username `admin`, password `12345`

### Troubleshooting Common Issues

**Connection Issues:**
- Verify PostgreSQL is running (check Task Manager on Windows)
- Confirm database credentials in `connection.php`
- Check if PHP PostgreSQL extension is enabled

**Apache Issues:**
- Port 80 might be in use - change Apache port in XAMPP config
- Check Apache error logs in XAMPP control panel

**Database Issues:**
- Ensure all tables are created properly
- Check PostgreSQL logs for connection errors
- Verify user permissions on the database

### Testing the Setup

1. **Basic Test**
   - Navigate to `http://localhost/GameStore/`
   - You should see the game listing page

2. **Registration Test**
   - Go to register page
   - Create a new user account
   - Check if user appears in database

3. **Admin Test**
   - Login with admin credentials
   - Access admin panel to add games

4. **Purchase Test**
   - Login as regular user
   - Browse store and purchase a game
   - Check library and transaction history

## 🔧 Development Environment Setup
## 🔧 Development Environment Setup

### For Developers

1. **Code Editor Setup**
   - Use VS Code, PHPStorm, or any preferred editor
   - Install PHP and SQL syntax highlighting extensions

2. **PHP Extensions Required**
   - Ensure these PHP extensions are enabled:
     ```ini
     extension=pgsql
     extension=pdo_pgsql
     extension=session
     ```

3. **Local Development Best Practices**
   - Keep database credentials in a separate config file
   - Use version control (Git) for code management
   - Test on multiple browsers for compatibility

### Project File Structure for Local Development
```
GameStore/                    # Main project directory
├── connection.php           # Database configuration (update this!)
├── index.php               # Entry point - game listings
├── login.php               # User authentication
├── register.php            # User registration
├── dashboard.php           # User library
├── storepage.php          # Browse all games
├── game.php               # Individual game details
├── buy.php                # Purchase processing
├── transaction.php        # Transaction history
├── admin.php              # Admin panel
├── logout.php             # Session cleanup
├── style.css              # Custom styles
├── script.js              # Client-side functionality
└── README.md              # This file
```

### Environment Variables (Optional)
For better security, you can use environment variables:

1. **Create .env file** (in project root)
   ```env
   DB_HOST=localhost
   DB_NAME=gamestore
   DB_USER=postgres
   DB_PASS=your_password
   DB_PORT=5432
   ```

2. **Update connection.php to use environment variables**
   ```php
   $db_host = $_ENV['DB_HOST'] ?? 'localhost';
   $db_name = $_ENV['DB_NAME'] ?? 'postgres';
   $db_username = $_ENV['DB_USER'] ?? 'postgres';
   $db_password = $_ENV['DB_PASS'] ?? 'your_password';
   ```

## 🚀 Ready to Go!

Once you've completed the setup:

1. **Start your local server** (XAMPP/WAMP/MAMP or PHP built-in)
2. **Ensure PostgreSQL is running**
3. **Open your browser** and navigate to your local GameStore
4. **Begin testing** the application features

The application should now be running locally and ready for development or testing!

## 👤 User Roles

### Regular Users
- Browse and purchase games
- View personal library
- Track transaction history
- Manage account settings

### Admin Users
- All regular user privileges
- Add new games to the store
- View all games in admin panel
- Access admin-specific features

**Default Admin Credentials:**
- Username: `admin`
- Password: `12345`

## 🎯 Usage

### For Customers
1. **Register/Login**: Create an account or log in
2. **Browse Store**: Visit the store page to see available games
3. **View Game Details**: Click on any game for detailed information
4. **Purchase Games**: Use the buy button and select payment method
5. **Access Library**: View purchased games in your personal library
6. **Track Transactions**: Review purchase history in the transactions page

### For Administrators
1. **Login**: Use admin credentials to access admin panel
2. **Add Games**: Use the admin interface to add new games to the store
3. **Manage Catalog**: View and manage the complete game catalog

## 🔒 Security Features

- **Input Validation**: Protection against SQL injection attacks
- **Session Security**: Secure session management
- **Email Validation**: Server-side email format validation
- **Duplicate Prevention**: Prevents duplicate user registrations and game purchases
- **Password Protection**: Secure password handling

## 🎨 Design Features

- **Responsive Layout**: Works on desktop, tablet, and mobile devices
- **Dark Theme**: Modern dark color scheme with red accents
- **Interactive Tables**: Clickable rows with hover effects
- **Modal Windows**: Detailed game information in overlay windows
- **Smooth Animations**: CSS transitions for better user experience

## 📊 Database Relationships

- **Users ↔ Library**: One-to-many (users can own multiple games)
- **Users ↔ Transactions**: One-to-many (users can have multiple transactions)
- **Games ↔ Library**: One-to-many (games can be owned by multiple users)
- **Games ↔ Transactions**: One-to-many (games can have multiple purchase transactions)

## 🔧 Maintenance

### Adding New Games
Use the admin panel to add games with the following information:
- Title, description, release date
- Developer, publisher, platform
- Price, rating (1-10), review

### User Management
- User accounts are automatically created through registration
- Passwords are stored as plain text (consider hashing in production)
- Email validation prevents invalid email formats

## 📝 Future Enhancements

- Password hashing and security improvements
- Game image upload functionality  
- Advanced search and filtering
- User reviews and ratings system
- Shopping cart functionality
- Payment gateway integration
- Email notifications
- Game categories and genres
- Wishlist functionality

## 🤝 Contributing

This is an educational project demonstrating web development concepts with PHP and PostgreSQL. Feel free to fork and enhance the codebase while following best security practices.

## 📄 License

This project is for educational purposes. Please ensure proper security measures are implemented before any production use.