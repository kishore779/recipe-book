CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    ingredients TEXT,
    instructions TEXT,
    category VARCHAR(50),
    image_url VARCHAR(255)
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT,
    name VARCHAR(100),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id)
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);