# FinWise - Personal Finance Management Application

## Project Overview
FinWise is a modern web application designed to help users manage their personal finances effectively. It provides features for categorizing income and expenses, generating financial reports, and analyzing financial status through visual representations.

## Technologies
- **Backend:** Laravel 10.x
- **Frontend:** 
  - Blade Template Engine
  - Tailwind CSS
  - Chart.js (For visualizations)
- **Database:** MySQL
- **Authentication:** Laravel Breeze

## Features

### 1. User Management
- Registration and login
- Password reset
- Profile management

### 2. Category Management
- Create income and expense categories
- Edit and delete categories
- Category-based financial analysis

### 3. Transaction Management
- Record income and expenses
- Category-based classification
- Date and description tracking
- Edit and delete transactions

### 4. Financial Reporting
- Monthly income/expense summary
- Category-based spending analysis
- Date range filtering
- CSV export functionality

### 5. Dashboard
- Financial summary cards
- Income/expense trend graph
- Category distribution chart
- Recent transactions list

## Database Structure

### Users Table
- id (Primary Key)
- name
- email
- password
- created_at
- updated_at

### Categories Table
- id (Primary Key)
- name
- type (income/expense)
- description
- created_at
- updated_at

### Transactions Table
- id (Primary Key)
- amount
- type (income/expense)
- category_id (Foreign Key)
- user_id (Foreign Key)
- description
- transaction_date
- created_at
- updated_at

## Installation

1. Clone the project:
```bash
git clone https://github.com/yourusername/finwise.git
cd finwise
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Create .env file:
```bash
cp .env.example .env
```

4. Configure database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finwise
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Seed default categories:
```bash
php artisan db:seed
```

8. Start the application:
```bash
php artisan serve
npm run dev
```

## Usage

1. Register or login
2. Manage categories
3. Record your income and expenses
4. Track your financial status through the dashboard
5. Generate detailed reports

## Security Features
- CSRF protection
- XSS protection
- SQL injection prevention
- Encrypted data storage
- Session management

## Performance Optimizations
- Database indexing
- Eager loading
- Cache implementation
- Asset minification

## Future Features
- Budget planning
- Goal setting
- Multi-currency support
- Mobile application
- API integration

## Contributing
1. Fork the project
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact
Project Owner - [@yourusername](https://github.com/BrplT0)

Project Link: [https://github.com/yourusername/finwise](https://github.com/BrplT0/finwise)
