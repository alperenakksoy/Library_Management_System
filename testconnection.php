CREATE DATABASE library_db;
USE library_db;

CREATE TABLE users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    pwd VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,  -- admin or not
    register_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Books table
CREATE TABLE books (
    bookid INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    status ENUM('available', 'borrowed') DEFAULT 'available',
    category VARCHAR(255),
    publisher VARCHAR(255),
    language VARCHAR(255) DEFAULT 'English',
    year_of_publication INT,
    pages INT,
    copies INT DEFAULT 1,
    location VARCHAR(50),
    isbn VARCHAR(15),
    added_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    borrow_bookID INT NOT NULL,
    borrow_userid INT NOT NULL,
    borrow_date DATE NOT NULL,
    return_date DATE,
    status ENUM('borrowed', 'returned') DEFAULT 'borrowed',
    FOREIGN KEY (borrow_bookID) REFERENCES books(bookid) ON DELETE CASCADE,  -- Corrected column name and reference
    FOREIGN KEY (borrow_userid ) REFERENCES users(userid) ON DELETE CASCADE       -- Added foreign key for user
);


INSERT INTO users(First_name, Last_name, email, pwd, is_admin) VALUES
('Alperen', 'Aksoy', 'alperenaksoy61@gmail.com','Password123',true),
('Ceyda','Celik','ceydacelik@gmail.com','deneme123',false);



INSERT INTO borrow_records(borrow_bookID, borrow_userid, borrow_date) VALUES
(12,2,'2024-12-12');

INSERT INTO borrow_records(borrow_bookID, borrow_userid, borrow_date) VALUES
(17,2,'2024-12-04');

select * from users;





show databases;
USE library_db;

drop table books;
SELECT * FROM books;

INSERT INTO books (title, author, category, publisher, isbn, year_of_publication, language, pages, copies, location)
VALUES
-- English Books
('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 'J.B. Lippincott & Co.', '9780061120084', 1960, 'English', 281, 4, 'Shelf A1'),
('1984', 'George Orwell', 'Dystopian', 'Secker & Warburg', '9780451524935', 1949, 'English', 328, 5, 'Shelf B1'),
('Pride and Prejudice', 'Jane Austen', 'Romance', 'Thomas Egerton', '9780141199078', 1813, 'English', 279, 3, 'Shelf C1'),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 'Scribner', '9780743273565', 1925, 'English', 180, 3, 'Shelf A2'),
('The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 'Little, Brown and Company', '9780316769488', 1951, 'English', 214, 2, 'Shelf A3'),

-- Turkish Books
('Saatleri Ayarlama Enstitüsü', 'Ahmet Hamdi Tanpınar', 'Fiction', 'Dergah', '9789759952773', 1961, 'Turkish', 412, 3, 'Shelf T1'),
('Kürk Mantolu Madonna', 'Sabahattin Ali', 'Romance', 'Yapı Kredi Yayınları', '9789753638024', 1943, 'Turkish', 177, 2, 'Shelf T2'),
('Tutunamayanlar', 'Oğuz Atay', 'Philosophy', 'İletişim Yayınları', '9789754700033', 1971, 'Turkish', 724, 2, 'Shelf T3'),
('Çalıkuşu', 'Reşat Nuri Güntekin', 'Romance', 'İnkılap Kitabevi', '9789751023418', 1922, 'Turkish', 408, 5, 'Shelf T4'),
('Beyaz Kale', 'Orhan Pamuk', 'Historical', 'Can Yayınları', '9789750734278', 1985, 'Turkish', 160, 3, 'Shelf T5'),

-- Italian Books
('The Divine Comedy', 'Dante Alighieri', 'Epic', 'Nuova Biblioteca', '9780199535644', 1320, 'Italian', 798, 1, 'Shelf I1'),
('The Name of the Rose', 'Umberto Eco', 'Mystery', 'Bompiani', '9780156001311', 1980, 'Italian', 512, 4, 'Shelf I2'),
('My Brilliant Friend', 'Elena Ferrante', 'Fiction', 'Edizioni e/o', '9781609450786', 2011, 'Italian', 331, 3, 'Shelf I3'),
('If on a Winter\'s Night a Traveler', 'Italo Calvino', 'Fiction', 'Einaudi', '9780156439619', 1979, 'Italian', 256, 2, 'Shelf I4'),
('Foucault\'s Pendulum', 'Umberto Eco', 'Philosophy', 'Bompiani', '9780156032971', 1988, 'Italian', 641, 2, 'Shelf I5'),

-- Spanish Books
('Don Quixote', 'Miguel de Cervantes', 'Fiction', 'Francisco de Robles', '9780060934347', 1605, 'Spanish', 992, 3, 'Shelf S1'),
('One Hundred Years of Solitude', 'Gabriel Garcia Marquez', 'Magical Realism', 'Editorial Sudamericana', '9780060883287', 1967, 'Spanish', 417, 4, 'Shelf S2'),
('Love in the Time of Cholera', 'Gabriel Garcia Marquez', 'Romance', 'Editorial Oveja Negra', '9780307389732', 1985, 'Spanish', 348, 2, 'Shelf S3'),
('The Shadow of the Wind', 'Carlos Ruiz Zafón', 'Mystery', 'Planeta', '9780143034902', 2001, 'Spanish', 487, 3, 'Shelf S4'),
('The House of the Spirits', 'Isabel Allende', 'Magical Realism', 'Debolsillo', '9780553383805', 1982, 'Spanish', 433, 4, 'Shelf S5'),

-- Arabic Books
('The Prophet', 'Kahlil Gibran', 'Philosophy', 'Alfred A. Knopf', '9780394404288', 1923, 'Arabic', 107, 5, 'Shelf AR1'),
('Season of Migration to the North', 'Tayeb Salih', 'Historical', 'Heinemann', '9780435905461', 1966, 'Arabic', 169, 3, 'Shelf AR2'),
('Men in the Sun', 'Ghassan Kanafani', 'Fiction', 'Arab Institute for Research', '9780140141026', 1962, 'Arabic', 71, 2, 'Shelf AR3'),
('Palace Walk', 'Naguib Mahfouz', 'Historical', 'Dar Misr', '9780385264662', 1956, 'Arabic', 498, 3, 'Shelf AR4'),
('Cities of Salt', 'Abdul Rahman Munif', 'Historical', 'Random House', '9780394755267', 1984, 'Arabic', 627, 2, 'Shelf AR5'),

('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'George Allen & Unwin', '9780547928227', 1937, 'English', 310, 4, 'Shelf A4'),
('The Fellowship of the Ring', 'J.R.R. Tolkien', 'Fantasy', 'George Allen & Unwin', '9780618574940', 1954, 'English', 423, 3, 'Shelf A5'),
('Dune', 'Frank Herbert', 'Science Fiction', 'Chilton Books', '9780441172719', 1965, 'English', 412, 5, 'Shelf B2'),
('Brave New World', 'Aldous Huxley', 'Dystopian', 'Chatto & Windus', '9780060850524', 1932, 'English', 311, 2, 'Shelf B3'),
('The Road', 'Cormac McCarthy', 'Post-apocalyptic', 'Alfred A. Knopf', '9780307387899', 2006, 'English', 287, 4, 'Shelf C2'),

-- Turkish Books
('Puslu Kıtalar Atlası', 'İhsan Oktay Anar', 'Fiction', 'İletişim Yayınları', '9789750505298', 1995, 'Turkish', 240, 3, 'Shelf T6'),
('Aşk', 'Elif Şafak', 'Romance', 'Doğan Kitap', '9786050902277', 2009, 'Turkish', 419, 5, 'Shelf T7'),
('Masumiyet Müzesi', 'Orhan Pamuk', 'Romance', 'İletişim Yayınları', '9789750507292', 2008, 'Turkish', 592, 2, 'Shelf T8'),
('İnce Memed', 'Yaşar Kemal', 'Fiction', 'Yapı Kredi Yayınları', '9789750802991', 1955, 'Turkish', 436, 4, 'Shelf T9'),
('Suskunlar', 'İhsan Oktay Anar', 'Historical', 'İletişim Yayınları', '9789754707032', 2007, 'Turkish', 242, 3, 'Shelf T10'),

-- Italian Books
('The Betrothed', 'Alessandro Manzoni', 'Historical', 'Mondadori', '9788804582895', 1827, 'Italian', 720, 2, 'Shelf I6'),
('Zeno\'s Conscience', 'Italo Svevo', 'Psychological Fiction', 'Einaudi', '9781400079681', 1923, 'Italian', 437, 1, 'Shelf I7'),
('The Leopard', 'Giuseppe Tomasi di Lampedusa', 'Historical', 'Feltrinelli', '9780375714795', 1958, 'Italian', 320, 3, 'Shelf I8'),
('The Garden of the Finzi-Continis', 'Giorgio Bassani', 'Historical', 'Feltrinelli', '9781566633237', 1962, 'Italian', 272, 2, 'Shelf I9'),
('Life A User\'s Manual', 'Italo Calvino', 'Fiction', 'Einaudi', '9780151006922', 1978, 'Italian', 400, 1, 'Shelf I10'),

-- Spanish Books
('Labyrinths', 'Jorge Luis Borges', 'Short Stories', 'Emece Editores', '9780811216999', 1962, 'Spanish', 256, 4, 'Shelf S6'),
('Pedro Páramo', 'Juan Rulfo', 'Magical Realism', 'Fondo de Cultura Economica', '9788420469205', 1955, 'Spanish', 124, 3, 'Shelf S7'),
('Like Water for Chocolate', 'Laura Esquivel', 'Magical Realism', 'Editorial Planeta', '9780385420174', 1989, 'Spanish', 256, 5, 'Shelf S8'),
('Hopscotch', 'Julio Cortázar', 'Fiction', 'Editorial Sudamericana', '9780394752846', 1963, 'Spanish', 564, 2, 'Shelf S9'),
('Aura', 'Carlos Fuentes', 'Mystery', 'Editorial Planeta', '9786071619629', 1962, 'Spanish', 160, 3, 'Shelf S10'),

-- Arabic Books
('The Yacoubian Building', 'Alaa Al Aswany', 'Fiction', 'Dar El Shorouk', '9789770929015', 2002, 'Arabic', 252, 3, 'Shelf AR6'),
('Women of Sand and Myrrh', 'Hanan al-Shaykh', 'Fiction', 'Anchor', '9780385423434', 1989, 'Arabic', 256, 2, 'Shelf AR7'),
('The Book of Khalid', 'Ameen Rihani', 'Philosophy', 'Dodd, Mead & Co.', '9780918172016', 1911, 'Arabic', 325, 1, 'Shelf AR8'),
('The Sand Fish', 'Maha Gargash', 'Historical', 'HarperCollins', '9780061744679', 2009, 'Arabic', 336, 3, 'Shelf AR9'),
('Celestial Bodies', 'Jokha Alharthi', 'Fiction', 'Dar Al-Adab', '9789776272165', 2010, 'Arabic', 243, 5, 'Shelf AR10'),

-- English Books
('Fahrenheit 451', 'Ray Bradbury', 'Dystopian', 'Ballantine Books', '9781451673319', 1953, 'English', 158, 3, 'Shelf A6'),
('The Handmaid\'s Tale', 'Margaret Atwood', 'Dystopian', 'McClelland & Stewart', '9780385490818', 1985, 'English', 311, 4, 'Shelf A7'),
('The Picture of Dorian Gray', 'Oscar Wilde', 'Philosophy', 'Ward, Lock & Co.', '9780141439570', 1890, 'English', 254, 2, 'Shelf A8'),
('Moby Dick', 'Herman Melville', 'Adventure', 'Harper & Brothers', '9780142437247', 1851, 'English', 585, 5, 'Shelf B4'),
('Catch-22', 'Joseph Heller', 'Satire', 'Simon & Schuster', '9781451626650', 1961, 'English', 453, 4, 'Shelf C3'),

-- Turkish Books
('Kavim', 'Selim İleri', 'Fiction', 'Can Yayınları', '9789755106892', 1997, 'Turkish', 320, 3, 'Shelf T11'),
('Bütün Dünya', 'Yusuf Atılgan', 'Fiction', 'İletişim Yayınları', '9789754700309', 1977, 'Turkish', 128, 2, 'Shelf T12'),
('Hayvan Çiftliği', 'George Orwell', 'Satire', 'Can Yayınları', '9789750731987', 1945, 'Turkish', 132, 5, 'Shelf T13'),
('Anlatmaya Başlasam', 'Zülfü Livaneli', 'Drama', 'Doğan Kitap', '9789759911428', 1996, 'Turkish', 254, 4, 'Shelf T14'),
('Serenad', 'Zülfü Livaneli', 'Romance', 'Doğan Kitap', '9786050913747', 2012, 'Turkish', 480, 3, 'Shelf T15'),

-- Italian Books
('Invisible Cities', 'Italo Calvino', 'Fiction', 'Harcourt Brace Jovanovich', '9780156027552', 1972, 'Italian', 265, 4, 'Shelf I11'),
('The Baron in the Trees', 'Italo Calvino', 'Adventure', 'Harcourt Brace & Co.', '9780156440646', 1957, 'Italian', 347, 2, 'Shelf I12'),
('The Path to the Nest of Spiders', 'Italo Calvino', 'Historical Fiction', 'Einaudi', '9780880014557', 1947, 'Italian', 226, 3, 'Shelf I13'),
('The Birth of Venus', 'Sarah Dunant', 'Historical Fiction', 'Hachette UK', '9780316722078', 2003, 'Italian', 456, 3, 'Shelf I14'),
('The Betrothed', 'Alessandro Manzoni', 'Historical Fiction', 'Feltrinelli', '9788807813635', 1827, 'Italian', 720, 2, 'Shelf I15'),

-- Spanish Books
('The Alchemist', 'Paulo Coelho', 'Fiction', 'HarperOne', '9780061122415', 1988, 'Spanish', 208, 3, 'Shelf S11'),
('The Time of the Hero', 'Mario Vargas Llosa', 'Historical Fiction', 'Editorial Seix Barral', '9788432216940', 1963, 'Spanish', 384, 3, 'Shelf S12'),
('The General in His Labyrinth', 'Gabriel Garcia Marquez', 'Historical Fiction', 'Editorial Sudamericana', '9780307387349', 1989, 'Spanish', 392, 4, 'Shelf S13'),
('The House of Spirits', 'Isabel Allende', 'Magical Realism', 'Planeta', '9780060922894', 1982, 'Spanish', 433, 5, 'Shelf S14'),
('The Labyrinth of the Spirits', 'Carlos Ruiz Zafón', 'Fiction', 'Penguin', '9780399585414', 2018, 'Spanish', 800, 2, 'Shelf S15'),

-- Arabic Books
('The Secret Life of Saeed', 'Emile Habiby', 'Satire', 'Arab Institute for Research', '9780863562094', 1974, 'Arabic', 204, 3, 'Shelf AR11'),
('The Angel\'s Game', 'Carlos Ruiz Zafón', 'Fiction', 'Penguin Books', '9780141032275', 2008, 'Arabic', 463, 3, 'Shelf AR12'),
('The Cairo Trilogy', 'Naguib Mahfouz', 'Historical Fiction', 'Doubleday', '9780385262742', 1956, 'Arabic', 720, 2, 'Shelf AR13'),
('The Hidden Face of Eve', 'Nawal El Saadawi', 'Feminism', 'Zed Books', '9781848136676', 1977, 'Arabic', 263, 3, 'Shelf AR14'),
('The Three Daughters of Eve', 'Elif Shafak', 'Fiction', 'Viking', '9780670017972', 2016, 'Arabic', 340, 4, 'Shelf AR15'),

-- English Books
('1984', 'George Orwell', 'Dystopian', 'Secker & Warburg', '9780451524935', 1949, 'English', 328, 5, 'Shelf A9'),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 'Charles Scribner\'s Sons', '9780743273565', 1925, 'English', 180, 4, 'Shelf A10'),
('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 'J.B. Lippincott & Co.', '9780061120084', 1960, 'English', 281, 5, 'Shelf A11'),
('The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 'Little, Brown and Company', '9780316769488', 1951, 'English', 277, 4, 'Shelf B5'),
('Pride and Prejudice', 'Jane Austen', 'Romance', 'T. Egerton, Whitehall', '9780141439512', 1813, 'English', 279, 5, 'Shelf B6'),

-- Turkish Books
('Kayıp Aranıyor', 'Sait Faik Abasıyanık', 'Short Story', 'Can Yayınları', '9789750705325', 1954, 'Turkish', 182, 3, 'Shelf T16'),
('Bir Çocuk', 'Feride Aksu', 'Children\'s Literature', 'Can Yayınları', '9789750708456', 1991, 'Turkish', 220, 4, 'Shelf T17'),
('Dönüşüm', 'Franz Kafka', 'Psychological Fiction', 'İletişim Yayınları', '9789754701290', 1915, 'Turkish', 128, 5, 'Shelf T18'),
('Sinekli Bakkal', 'Halide Edib Adıvar', 'Drama', 'Varlık Yayınları', '9789750698994', 1936, 'Turkish', 304, 3, 'Shelf T19'),
('Çalıkuşu', 'Reşat Nuri Güntekin', 'Drama', 'Yapı Kredi Yayınları', '9789750804292', 1922, 'Turkish', 430, 4, 'Shelf T20'),

-- Italian Books
('If on a Winter\'s Night a Traveler', 'Italo Calvino', 'Fiction', 'Harcourt', '9780156440868', 1979, 'Italian', 260, 3, 'Shelf I16'),
('Invisible Cities', 'Italo Calvino', 'Fiction', 'Harcourt', '9780156027552', 1972, 'Italian', 265, 3, 'Shelf I17'),
('The Tartar Steppe', 'Dino Buzzati', 'Adventure', 'Feltrinelli', '9788807035609', 1940, 'Italian', 264, 2, 'Shelf I18'),
('The Garden of Angels', 'Nino Ricci', 'Historical Fiction', 'Doubleday', '9780385495189', 1996, 'Italian', 307, 4, 'Shelf I19'),
('My Brilliant Friend', 'Elena Ferrante', 'Fiction', 'Europa Editions', '9781609450786', 2012, 'Italian', 400, 5, 'Shelf I20'),

-- Spanish Books
('One Hundred Years of Solitude', 'Gabriel García Márquez', 'Magical Realism', 'Harper & Row', '9780060883287', 1967, 'Spanish', 417, 5, 'Shelf S16'),
('Love in the Time of Cholera', 'Gabriel García Márquez', 'Romance', 'Alfred A. Knopf', '9781400034710', 1985, 'Spanish', 348, 4, 'Shelf S17'),
('Chronicle of a Death Foretold', 'Gabriel García Márquez', 'Fiction', 'Editorial Planeta', '9780307386403', 1981, 'Spanish', 192, 5, 'Shelf S18'),
('The Shadow of the Wind', 'Carlos Ruiz Zafón', 'Mystery', 'Penguin Books', '9780385721790', 2001, 'Spanish', 487, 4, 'Shelf S19'),
('The Angel\'s Game', 'Carlos Ruiz Zafón', 'Fiction', 'Penguin Books', '9780141032275', 2008, 'Spanish', 463, 3, 'Shelf S20'),

-- Arabic Books
('Season of Migration to the North', 'Tayeb Salih', 'Fiction', 'Heinemann', '9780435903912', 1966, 'Arabic', 165, 3, 'Shelf AR16'),
('The Cairo Diaries', 'Naguib Mahfouz', 'Fiction', 'Doubleday', '9780385262490', 1990, 'Arabic', 260, 2, 'Shelf AR17'),
('Women at Point Zero', 'Nawal El Saadawi', 'Fiction', 'Zed Books', '9781848133668', 2007, 'Arabic', 200, 5, 'Shelf AR18'),
('The Swallows of Kabul', 'Yasmina Khadra', 'Fiction', 'Viking', '9780142004537', 2002, 'Arabic', 288, 4, 'Shelf AR19'),
('The Arab of the Future', 'Riad Sattouf', 'Graphic Novel', 'L\'Armatan', '9780425281172', 2014, 'Arabic', 304, 3, 'Shelf AR20'),

-- English Books
('Brave New World', 'Aldous Huxley', 'Dystopian', 'Chatto & Windus', '9780060850524', 1932, 'English', 268, 5, 'Shelf A12'),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'George Allen & Unwin', '9780261103344', 1937, 'English', 310, 5, 'Shelf A13'),
('The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 'George Allen & Unwin', '9780261102385', 1954, 'English', 1178, 4, 'Shelf B7'),
('Crime and Punishment', 'Fyodor Dostoevsky', 'Psychological Fiction', 'The Russian Messenger', '9780140449136', 1866, 'English', 430, 3, 'Shelf A14'),

-- Turkish Books
('Aşk', 'Elif Şafak', 'Romance', 'Doğan Kitap', '9789759916881', 2009, 'Turkish', 387, 4, 'Shelf T21'),
('İstanbul Hatırası', 'Ahmet Ümit', 'Mystery', 'İnkılap Kitabevi', '9789751036341', 2003, 'Turkish', 366, 5, 'Shelf T22'),
('Gülün Adı', 'Umberto Eco', 'Mystery', 'Yapı Kredi Yayınları', '9789750800027', 1980, 'Turkish', 480, 3, 'Shelf T23'),
('Beni Hiç Göremezsin', 'Ayla Kutlu', 'Romance', 'Can Yayınları', '9789755107882', 1983, 'Turkish', 294, 4, 'Shelf T24'),
('Bir Kadın', 'Tezer Özlü', 'Fiction', 'Yapı Kredi Yayınları', '9789750805169', 1984, 'Turkish', 150, 2, 'Shelf T25'),

-- Italian Books
('The Betrothed', 'Alessandro Manzoni', 'Historical Fiction', 'Edizioni Mondadori', '9788804621460', 1840, 'Italian', 723, 5, 'Shelf I21'),
('My Brilliant Friend', 'Elena Ferrante', 'Fiction', 'Europa Editions', '9781609450762', 2012, 'Italian', 400, 4, 'Shelf I22'),
('The Lying Life of Adults', 'Elena Ferrante', 'Fiction', 'Europa Editions', '9781609455910', 2020, 'Italian', 357, 3, 'Shelf I23'),
('The Leopard', 'Giuseppe Tomasi di Lampedusa', 'Historical Fiction', 'Feltrinelli', '9788807017490', 1958, 'Italian', 496, 4, 'Shelf I24'),
('In the Name of the Family', 'Sarah Dunant', 'Biography', 'Random House', '9781400076687', 2017, 'Italian', 384, 3, 'Shelf I25'),

-- Spanish Books
('The House of the Spirits', 'Isabel Allende', 'Magical Realism', 'Plaza & Janés', '9788401343344', 1982, 'Spanish', 467, 5, 'Shelf S21'),
('The Infinite Plan', 'Isabel Allende', 'Fiction', 'HarperCollins', '9780060931858', 1999, 'Spanish', 380, 4, 'Shelf S22'),
('The Invention of Morel', 'Adolfo Bioy Casares', 'Science Fiction', 'Grove Press', '9780802131246', 1940, 'Spanish', 213, 5, 'Shelf S23'),
('The Old Man Who Read Love Stories', 'Luis Sepúlveda', 'Fiction', 'Penguin Books', '9780140167832', 1989, 'Spanish', 224, 4, 'Shelf S24'),
('Love in the Time of Cholera', 'Gabriel García Márquez', 'Romance', 'Alfred A. Knopf', '9781400034710', 1985, 'Spanish', 348, 5, 'Shelf S25'),

-- Arabic Books
('The Yacoubian Building', 'Alaa Al Aswany', 'Fiction', 'American University in Cairo Press', '9789774249091', 2002, 'Arabic', 375, 5, 'Shelf AR21'),
('The Prophet', 'Kahlil Gibran', 'Poetry', 'Alfred A. Knopf', '9780394414402', 1923, 'Arabic', 96, 6, 'Shelf AR22'),
('The Book of Disappearance', 'Ibtisam Azem', 'Fiction', 'Syracuse University Press', '9780815609310', 2014, 'Arabic', 207, 4, 'Shelf AR23'),
('The Cairo Trilogy', 'Naguib Mahfouz', 'Fiction', 'Doubleday', '9780385262742', 1956, 'Arabic', 720, 5, 'Shelf AR24'),
('Season of Migration to the North', 'Tayeb Salih', 'Fiction', 'Heinemann', '9780435903912', 1966, 'Arabic', 160, 3, 'Shelf AR25'),

-- English Books
('Moby-Dick', 'Herman Melville', 'Adventure', 'Harper & Brothers', '9781503280786', 1851, 'English', 585, 5, 'Shelf A15'),
('The Grapes of Wrath', 'John Steinbeck', 'Historical Fiction', 'Viking Press', '9780143039433', 1939, 'English', 464, 4, 'Shelf A16'),
('Catch-22', 'Joseph Heller', 'Satire', 'Simon & Schuster', '9781451626650', 1961, 'English', 453, 5, 'Shelf A17'),
('Fahrenheit 451', 'Ray Bradbury', 'Dystopian', 'Ballantine Books', '9781451673319', 1953, 'English', 249, 4, 'Shelf A18'),
('Slaughterhouse-Five', 'Kurt Vonnegut', 'Science Fiction', 'Delacorte Press', '9780385333849', 1969, 'English', 275, 3, 'Shelf A19'),

-- Turkish Books
('İnce Memed', 'Yaşar Kemal', 'Historical Fiction', 'Yapı Kredi Yayınları', '9789750807392', 1955, 'Turkish', 520, 5, 'Shelf T26'),
('Feryad', 'Nedim Gürsel', 'Fiction', 'Can Yayınları', '9789750704454', 1989, 'Turkish', 280, 4, 'Shelf T27'),
('Korkuyu Beklerken', 'Ahmet Ümit', 'Mystery', 'İletişim Yayınları', '9789754702297', 1996, 'Turkish', 396, 3, 'Shelf T28'),
('Görülmüştür', 'Hikmet Genç', 'Philosophy', 'Büyük Doğu Yayınları', '9789750806920', 1995, 'Turkish', 150, 4, 'Shelf T29'),
('Hayaline Firar Etme', 'Zülfü Livaneli', 'Fiction', 'Can Yayınları', '9789750706458', 1999, 'Turkish', 370, 5, 'Shelf T30'),

-- Italian Books
('The Garden of Angels', 'Nino Ricci', 'Historical Fiction', 'Doubleday', '9780385495189', 1996, 'Italian', 324, 5, 'Shelf I26'),
('The Divine Comedy', 'Dante Alighieri', 'Epic Poetry', 'Mondadori', '9788804640507', 1320, 'Italian', 798, 4, 'Shelf I27'),
('The Birth of Venus', 'Sarah Dunant', 'Historical Fiction', 'Random House', '9780385495196', 2003, 'Italian', 405, 5, 'Shelf I28'),
('The Betrothed', 'Alessandro Manzoni', 'Historical Fiction', 'Edizioni Mondadori', '9788804621460', 1840, 'Italian', 723, 3, 'Shelf I29'),
('The House on the Hill', 'Francesca P. Santucci', 'Fiction', 'Franco Angeli', '9788820429389', 2011, 'Italian', 350, 2, 'Shelf I30'),

-- Spanish Books
('Don Quixote', 'Miguel de Cervantes', 'Classic', 'Francisco de Robles', '9780060931780', 1605, 'Spanish', 1072, 5, 'Shelf S26'),
('The Shadow of the Wind', 'Carlos Ruiz Zafón', 'Mystery', 'Penguin Books', '9780385721790', 2001, 'Spanish', 487, 4, 'Shelf S27'),
('The Secret Garden', 'Frances Hodgson Burnett', 'Children\'s Literature', 'E. P. Dutton', '9780142437049', 1911, 'Spanish', 390, 4, 'Shelf S28'),
('The Angel\'s Game', 'Carlos Ruiz Zafón', 'Fiction', 'Penguin Books', '9780141032275', 2008, 'Spanish', 463, 3, 'Shelf S29'),
('The Old Man Who Read Love Stories', 'Luis Sepúlveda', 'Fiction', 'Penguin Books', '9780140167832', 1989, 'Spanish', 224, 3, 'Shelf S30'),

-- Arabic Books
('The Yacoubian Building', 'Alaa Al Aswany', 'Fiction', 'American University in Cairo Press', '9789774249091', 2002, 'Arabic', 375, 4, 'Shelf AR26'),
('The Cairo Trilogy', 'Naguib Mahfouz', 'Fiction', 'Doubleday', '9780385262742', 1956, 'Arabic', 720, 5, 'Shelf AR27'),
('The Prophet', 'Kahlil Gibran', 'Poetry', 'Alfred A. Knopf', '9780394414402', 1923, 'Arabic', 96, 6, 'Shelf AR28'),
('The Swallows of Kabul', 'Yasmina Khadra', 'Fiction', 'Viking', '9780142004537', 2002, 'Arabic', 288, 4, 'Shelf AR29'),
('The Book of Disappearance', 'Ibtisam Azem', 'Fiction', 'Syracuse University Press', '9780815609310', 2014, 'Arabic', 207, 5, 'Shelf AR30');

select * from books;

