# The History Forum

![Spitfire Forum](my-app/public/images/amiresponsive.png)

A history forum made in laravel. Users can register, post discussions, vote on content, and engage with others through comments. All within a clean, historically themed interface.

---

## Features

- **Forum** — browse and filter posts by genre/topic with instant AJAX filtering and client-side pagination
- **Trending** — sidebar showing the top 10 most upvoted posts
- **Posts** — create, edit, and delete your own discussions
- **Voting** — upvote or downvote posts; vote again to remove your vote
- **Comments** — leave comments on any post
- **Authentication** — register, login with remember me, update account settings, logout

---

## Tech stack


### Backend
 · PHP ,Laravel           
### Frontend 
 - Vanilla JS (ES modules) · Vite 
### Styling  
 - CSS                   
### Database  
 - MySQL                          
### Auth 
 - Laravel session authentication 

## Local setup

Requires [XAMPP](https://www.apachefriends.org/) and [Node.js](https://nodejs.org/).

```bash
# 1. Start Apache and MySQL in XAMPP

# 2. Install PHP dependencies
cd my-app
composer install

# 3. Configure environment
cp .env.example .env
php artisan key:generate
```

Set your database credentials in `.env`:
```
DB_DATABASE=spitfire
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 4. Run migrations
php artisan migrate

# 5. Install JS dependencies and build
npm install
npm run dev

# 6. Serve
php artisan serve
```

Visit `http://localhost:8000`.

---

## Routes

| Method | URI | Description | Auth |
|--------|-----|-------------|------|
| GET | `/` | Home | — |
| GET | `/forum` | Forum (supports `?genre=` filter) | — |
| GET | `/forum/create` | Create post form | Required |
| POST | `/forum/create` | Store new post | Required |
| GET | `/forum/{post}` | View post and comments | — |
| GET | `/forum/{post}/edit` | Edit post form | Owner only |
| PUT | `/forum/{post}` | Update post | Owner only |
| DELETE | `/forum/{post}` | Delete post | Owner only |
| POST | `/forum/{post}/vote` | Cast or toggle a vote | Required |
| POST | `/forum/{post}/comment` | Add a comment | Required |
| GET | `/account` | Login / register | — |
| POST | `/account/register` | Register | — |
| POST | `/account/login` | Login | — |
| POST | `/account/settings` | Update account settings | Required |
| POST | `/account/logout` | Logout | Required |
