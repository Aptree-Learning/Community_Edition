# Aptree - The Next Generation Learning Management System

![Aptree Logo](https://aptreelearning.com/content/images/2023/08/-aptreelogo-1.png)

Aptree is a state-of-the-art Learning Management System (LMS) built with a focus on ease of use, versatility, and efficiency. Designed by a group of passionate educators, Aptree aims to revolutionize the e-learning space, offering intuitive features powered by advanced technologies, including a cutting-edge generative AI for automated content and question creation.

## Features

-   **Best-in-Class Authoring Interface**: Create courses with ease, featuring an intuitive design and user experience.
-   **Generative AI Integration**: Automate the creation of multiple-choice questions and content, tailored to individual learning styles and preferences.
-   **Gamified Course Player**: Engage students with an interactive and gamified learning environment.
-   **Built-in Video and Screen Recording**: Enhance learning materials with integrated video and screen recording features.
-   **ChatGPT Integration**: Facilitate real-time interaction and assistance powered by advanced AI.
-   **Unsplash Integration**: Access a vast library of images to enrich your educational content.
-   **Zapier Integration**: Automate workflows and integrate with thousands of apps seamlessly.
-   **Easy Installation**: Get up and running with minimal setup, thanks to our streamlined installation process.
-   **White-Labelled Experience**: Customize Aptree to reflect your institution’s branding and identity.

# Installing on Localhost

This guide will walk you through the installation process for setting up aptree, a modern, open-source learning platform built using the TALL stack—Tailwind CSS, Alpine.js, Laravel, and Livewire.

## Introduction

This guide will walk you through the installation process for setting up aptree, a modern, open-source learning platform built using the TALL stack—Tailwind CSS, Alpine.js, Laravel, and Livewire.

## Prerequisites

-   PHP >= 8.0
-   Composer
-   npm or yarn
-   Database (MySQL, PostgreSQL, SQLite, etc.)

## Steps

### 1. Clone the aptree Repository

First, clone the aptree repository from GitHub (or wherever your project is hosted) to your local machine.

```bash
gh repo clone https://github.com/Aptree-Learning/Community_Edition.git

```

Copy

### 2. Navigate to the Project Directory

Navigate into the aptree directory.

```bash
cd aptree

```

Copy

### 3. Install PHP Dependencies

Run the following command to install the necessary PHP dependencies.

```bash
composer install

```

Copy

### 4. Install JavaScript Dependencies

Next, install all JavaScript dependencies using npm.

```bash
npm install
```

Copy

### 5. Set Up Environment Variables

Copy the  `.env.example`  file to create a new  `.env`  file.

```bash
cp .env.example .env

```

Copy

### 6. Generate Application Key

Generate a new application key for your Laravel application.

```bash
php artisan key:generate

```

Copy

### 7. Set Up Database

Edit the  `.env`  file to add your database credentials.

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

```

Copy

then migrate the database

```bash
php artisan migrate
php artisan db:seed
```

Copy

### 8. Compile Assets

Compile your assets using npm.

```bash
npm run dev

```

Copy

or if you are using yarn

```bash
yarn dev

```



### 9. Run the Development Server

Finally, start the Laravel development server.

```bash
php artisan serve

```

Copy

This will start the development server, and your aptree platform will now be accessible at  `http://127.0.0.1:8000`

That's it! You've successfully set up aptree using the TALL stack on your localhost. Explore the platform and enjoy the advanced features for modern learning and content management!

## Note on Livewire and Alpine.js

Aptree is enhanced with Livewire and Alpine.js for a seamless and dynamic user experience. Ensure that your environment supports these technologies, and consult their respective documentation for any specific configurations or troubleshooting.

-   [Livewire Documentation](https://laravel-livewire.com/docs/2.x/quickstart)
-   [Alpine.js GitHub Repository](https://github.com/alpinejs/alpine)

----------

## Support

For any issues, please refer to our **[Documentation](https://aptreelearning.com/guides/)** or reach out to us through our website. 

## License

Aptree is licensed under the GNU v3 License


