---

```
# 📓 FUFUNotes – Make Your Life Better

A simple, beautiful **Notes CRUD web application** built with **PHP**, **MySQL**, **Bootstrap 5**, and **DataTables**.  
Perfect for beginners learning full-stack PHP development and database integration.

---

## 🌟 Features

- ✅ Add Notes with Title and Description  
- 📝 View Notes in a responsive, searchable, and sortable table  
- ❌ Delete Notes with confirmation prompt  
- 🎨 Clean and modern UI with Bootstrap 5  
- ⚡ Instant feedback alerts for successful operations  
- 🔐 SQL Injection protection using prepared statements  
- 🔍 Client-side search using DataTables  

---

## 📷 Screenshot

![FUFUNotes Screenshot](https://via.placeholder.com/800x400?text=FUFUNotes+App+Screenshot)

---

## 💻 Tech Stack

| Technology     | Usage                         |
|----------------|-------------------------------|
| PHP            | Server-side scripting         |
| MySQL          | Database                      |
| HTML + CSS     | Frontend structure & styling  |
| Bootstrap 5    | UI framework                  |
| jQuery         | JavaScript library            |
| DataTables     | Enhanced table functionality  |

---

### 2. Set up your MySQL database

Create a database named `curd` and a table called `notes`:

```sql
CREATE DATABASE IF NOT EXISTS curd;

USE curd;

CREATE TABLE `notes` (
  `sno` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(255) NOT NULL,
  `Description` TEXT NOT NULL,
  PRIMARY KEY (`sno`)
);
```

### 3. Start your local PHP server

```bash
php -S localhost:8000
```

Then, open your browser and go to:

```
http://localhost:8000
```

---

## 🧠 How It Works

### Adding Notes
- Submits form using POST.
- Server sanitizes input using `htmlspecialchars()` and adds data using prepared statements.

### Deleting Notes
- On button click, a JS `confirm()` dialog appears.
- If confirmed, a hidden form sends a POST request with the note’s serial number.
- Server executes a `DELETE` query using a prepared statement.

### Data Display
- Notes are fetched from the database and rendered as HTML.
- DataTables enhances the table with search, sort, and pagination.

---

## 🔐 Security Features

- ✅ SQL Injection safe via `prepare()` and `bind_param()`.
- ✅ User input sanitized using `htmlspecialchars()`.
- ✅ POST requests only – no unsafe GET-based actions.

---

---

## 🤝 Contributing

Contributions are welcome! Feel free to fork the repo and submit a pull request.

---

## 📄 License

Open Source Projects 

---

## 👨‍💻 Author

**Pavan Pandya**  
🌐 [GitHub Profile](https://github.com/PavanPandya016)

---
