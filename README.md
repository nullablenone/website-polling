# Polling Website

This website is a platform for creating and managing polls, built using Laravel and supporting technologies.

## 🎯 Project Goals

To provide a platform for creating interactive polls, including both text and photo polls, with features for both users and administrators.

## ✨ Main Features

### User Features

- **Login**: Authentication using Laravel UI.  
- **Create Polls**: Supports both regular and photo polls.  
- **User Dashboard**: View created polls, delete, and close polls.  
- **Voting**: Vote on polls created by other users.  

### Admin Features

- **Admin Dashboard**: Manage the list of users and the number of polls created by each user.  
- **Poll Limitation**: Restrict the number of polls a user can create. Admins have control to allow users to create additional polls. This limitation system works based on IP address and per account, automatically mitigating spam from multiple accounts.

**Note**: Some admin features are still under development.

## 🛠️ Technologies Used

- **Backend**: Laravel with Laravel UI for authentication.  
- **Role Management**: Laravel Spatie Role Permission.  
- **Frontend**: Bootstrap and JavaScript.  
- **Interactivity**: Sweet Alert.  

## 🚀 How to Run the Project

1. Clone this repository:  
   ```bash
   git clone <repository-url>
   cd <repository-folder>
   ```

2. Install dependencies:  
   ```bash
   composer install
   npm install
   ```

3. Create a `.env` file and configure your database settings. Then run:  
   ```bash
   php artisan migrate --seed
   ```

4. Start the server:  
   ```bash
   php artisan serve
   ```

5. Access the application at `http://localhost:8000`.

## 🚧 Project Status

This project is still under development, especially the admin features.
