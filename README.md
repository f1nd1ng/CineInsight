# 🎥 CineInsight

**CineInsight** offers a curated and immersive movie discovery experience by scraping data from IMDB to deliver intelligent recommendations, detailed reviews, and personalized movie lists—all in one sleek platform.

>  *Role: Full-Stack Web Developer, Designer*  
>  *Tech Stack: PHP · JavaScript · MySQL · HTML · CSS*

---

##  About CineInsight

CineInsight redefines how users engage with cinema by:

-  **Scraping IMDB** for real-time data to extract pivotal insights and trends.
-  **Curating Movies** that are not only popular but contextually relevant—sorted by language and genre.
-  **Displaying Ratings and Reviews** so users can make informed choices.
-  **Providing Personalized Recommendations** using user-selected preferences.
-  **Sharing Complete Movie Details** including:
  - IMDB ratings
  - Runtime
  - Language
  - Genre
  - Link to movie trailer
  - Platform availability
-  **Allowing Custom Movie Lists** so users can organize their favorites or watchlists their way.

---

##  Features

-  User Sign-Up with Profile Picture Upload
-  Session-Based Login System
-  Personalized Movie Dashboard
-  Filter by Language & Genre
-  Embedded Trailer Access
-  Custom User Movie Lists (Favorites, Watch Later, etc.)
-  Dynamic IMDB Ratings
-  Beautiful and Responsive UI (Bootstrap + Custom Styling)

---

##  Tech Stack

| Technology | Role |
|------------|------|
| **PHP** | Server-side logic, session handling |
| **MySQL** | Relational database to store user & movie data |
| **JavaScript** | UI interactivity and dynamic elements |
| **HTML5 / CSS3** | Structure and styling |
| **Bootstrap 5** | Responsive design components |

---

##  Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/cineinsight.git
   cd cineinsight

2. **Setting up the databse
   
   ```bash
   //CREATE DATABASE
   CREATE DATABASE cineinsight;
    USE cineinsight;
   //CREATE THE REQUIRED TABLES
   -- Users Table
    CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255)
    );

    -- Movies Table
    CREATE TABLE Movies (
      id INT PRIMARY KEY,
      movie_name VARCHAR(255),
      rating FLOAT,
      duration VARCHAR(50),
      language VARCHAR(100),
      genre VARCHAR(100),
      poster_image VARCHAR(255),
      trailer_link TEXT,
      platform VARCHAR(255)
    );
    
    -- User Movie Lists
    CREATE TABLE UserMovies (
      id INT,
      movieid INT,
      PRIMARY KEY (id, movieid)
    );
3. **Configure the Database Connection
   ```bash
   <?php
    $conn = new mysqli("localhost", "root", "", "cineinsight");
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    ?>
4. **RUN THE PROJECT
   ```bash
   php -S localhost:8000
    http://localhost:8000/sign_up.php


