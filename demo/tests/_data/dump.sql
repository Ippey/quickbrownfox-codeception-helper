CREATE TABLE authors (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE books (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title VARCHAR(255) NOT NULL,
  author_id INTEGER NOT NULL,
  price DECIMAL(8,2) NOT NULL,
  description TEXT NOT NULL,
  published_at DATE NOT NULL,
  updated_at DATETIME,
  FOREIGN KEY(author_id) REFERENCES authors(id)
);