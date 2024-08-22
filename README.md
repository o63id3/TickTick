# TickTick

TickTick is a task management application built with Laravel and Inertia.js. It helps you manage your tasks efficiently.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [Contributing](#contributing)

## Features

- **Authentication**: Register, login, and logout.
- **List Management**: Create, update, and delete lists.
- **Section Management**: Create, update, and delete section, as sections are associated to one list.
- **Task Management**: Create, update, and delete tasks , as tasks are associated to one section.
- **Task Items Management**: Create, update, and delete items, as items are associated to one task.
- **Task Prioritization**: Mark tasks as high, medium, low, or none priority.
- **Responsive Design**: Works seamlessly on both desktop and mobile devices.

[//]: # (- **Due Dates & Reminders**: Set due dates and receive reminders.)
[//]: # (- **Progress Tracking**: Track the progress of your tasks over time.)


## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/o63id3/TickTick.git
   cd TickTick
   
2. **Install dependencies:**
    ```bash
    composer install
    npm install

3. **Environment setup:**
    - Copy the .env.example to .env:
       ```bash
        cp .env.example .env
   - Generate the application key:
      ```bash
       php artisan key:generate

4. **Run migrations:**
    ```bash
   php artisan migrate --seed
   
5. **Compile assets:**
   ```bash
   npm run dev

6. **Start the development server:**
    ```bash
    php artisan serve

## Usage

After installing, you can access the application by navigating to http://localhost:8000 in your web browser. From there, you can create tasks, organize them into categories, and start managing your workflow.

## Configuration

Ensure you have the correct environment variables set up in your .env file, including the database connection, application URL, and other relevant settings.

## Contributing

Contributions are welcome! Please fork this repository and submit a pull request for any feature or bug fix.

